<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Repository\AdsRepository;
use App\Domain\Service\CalculatePointsForPicture;
use App\Domain\Service\CalculatePointsForDescription;
use App\Domain\Service\CalculatePointsForAdCompleted;
use App\Domain\Ad;

final class CalculateScoreUseCase
{
    private $adsRepository;
    private $calculatorPicture;
    private $calculatorDescription;
    private $calculatorAdCompleted;
    
    public function __construct(
        AdsRepository $adsRepository, 
        CalculatePointsForPicture $calculatorPicture,
        CalculatePointsForDescription $calculatorDescription,
        CalculatePointsForAdCompleted $calculatorAdCompleted    
    ) {
        $this->adsRepository = $adsRepository;
        $this->calculatorPicture = $calculatorPicture;
        $this->calculatorDescription = $calculatorDescription;
        $this->calculatorAdCompleted = $calculatorAdCompleted;
    }
    public function __invoke(): void
    {
        $ads = $this->adsRepository->listAll();
        
        $adsList = [];
        foreach ($ads as $ad) {
            $adEntity = new Ad(
                $ad->id(), 
                $ad->typology(), 
                $ad->description(), 
                $ad->pictures(), 
                $ad->houseSize(), 
                $ad->gardenSize(), 
                null,
                $ad->irrelevantSince()
            );
            
            $adCompleted = $this->runCalculator($adEntity);
            array_push($adsList, $adCompleted);
            
            echo "<pre>";
            print_r($adCompleted);
            echo "</pre>";
            echo "<hr />";
        }
        
        $this->adsRepository->update($adsList);
    }
    
    private function runCalculator($adEntity)
    {
        $adWithPictures = $this->calculatorPicture->calculate($adEntity);
        $adWithPicturesAndDescription = $this->calculatorDescription->calculate($adWithPictures);
        
        return $this->calculatorAdCompleted->calculate($adWithPicturesAndDescription);
    }
}
