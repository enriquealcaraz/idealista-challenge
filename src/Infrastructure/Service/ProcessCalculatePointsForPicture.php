<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Repository\PictureRepository;
use App\Domain\Service\CalculatePointsForPicture;
use App\Domain\Ad;
use App\Domain\Picture;

final class ProcessCalculatePointsForPicture implements CalculatePointsForPicture
{
    private PictureRepository $pictureRepository;
    
    public function __construct(PictureRepository $pictureRepository)
    {
        $this->pictureRepository = $pictureRepository;
    }
    
    public function calculate(Ad $ad): Ad
    {
        if (count($ad->pictures()) == 0) {
            $ad->loseScore(10);
            return $ad;
        }
        
        foreach ($ad->pictures() as $pictureId) {
            $picture = $this->pictureRepository->findById($pictureId);
            
            if ($picture->quality() == Picture::TYPE_HD) {
                $ad->winScore(20);
            }
            
            if ($picture->quality() == Picture::TYPE_SD) {
                $ad->winScore(10);
            }
        }

        return $ad;
    }
}
