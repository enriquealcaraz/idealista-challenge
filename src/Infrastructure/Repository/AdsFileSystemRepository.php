<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Infrastructure\Persistence\InFileSystemPersistence;
use App\Domain\Repository\AdsRepository;
use App\Domain\Repository\PictureRepository;
use App\Domain\PublicAd;
use App\Domain\QualityAd;
use App\Domain\Ad;

final class AdsFileSystemRepository implements AdsRepository
{
    private InFileSystemPersistence $inFileSystemPersistence;
    private PictureRepository $pictureRepository;
    
    public function __construct(
        InFileSystemPersistence $inFileSystemPersistence,
        PictureRepository $pictureRepository
    ) {
        $this->inFileSystemPersistence = $inFileSystemPersistence;
        $this->pictureRepository = $pictureRepository;
    }
    
    public function listAdsForIdealistUsers(): array
    {
        $ads = $this->inFileSystemPersistence->findAllAds();
        
        $adsForIdealistUsers = [];
        foreach ($ads as $ad) {
            if ($ad->score() > Ad::CUT_OFF_MARK) {
                $adsForIdealistUsers[] = new PublicAd($ad->id(), $ad->typology(), $ad->description(), $this->extractUrlPicturesFromAd($ad), $ad->houseSize(), $ad->gardenSize());
            }
        }        

        return $adsForIdealistUsers;
    }
    
    public function listAdsForQualityUsers(): array
    {
        $ads = $this->inFileSystemPersistence->findAllAds();
        
        $adsForQualityUsers = [];
        foreach ($ads as $ad) {
            if ($ad->score() < Ad::CUT_OFF_MARK) {
                $adsForQualityUsers[] = new QualityAd(
                    $ad->id(), 
                    $ad->typology(), 
                    $ad->description(), 
                    $this->extractUrlPicturesFromAd($ad),
                    $ad->houseSize(), 
                    $ad->gardenSize(), 
                    $ad->score(), 
                    $ad->irrelevantSince()
                );
            }
        }
        
        return $adsForQualityUsers;
    }
    
    public function listAll(): array
    {
        return $this->inFileSystemPersistence->findAllAds();
    }
    
    public function update($adsList): void
    {
        $this->inFileSystemPersistence->updateAds($adsList);
    }
    
    private function extractUrlPicturesFromAd($ad): array
    {
        $pictures = [];
        foreach ($ad->pictures() as $pictureId) {
            $pictures[] = $this->pictureRepository->findById($pictureId)->url();
        }
        
        return $pictures;
    }
}
