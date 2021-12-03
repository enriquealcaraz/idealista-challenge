<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\PersistenceRepository;
use App\Domain\Repository\AdsRepository;
use App\Domain\Repository\PictureRepository;
use App\Domain\PublicAd;
use App\Domain\QualityAd;
use App\Domain\Ad;

final class AdsFileSystemRepository implements AdsRepository
{
    private PersistenceRepository $persistenceRepository;
    private PictureRepository $pictureRepository;
    
    public function __construct(
        PersistenceRepository $persistenceRepository,
        PictureRepository $pictureRepository
    ) {
        $this->persistenceRepository = $persistenceRepository;
        $this->pictureRepository = $pictureRepository;
    }
    
    public function listAdsForIdealistUsers(): array
    {
        $ads = $this->persistenceRepository->findAllAds();
        
        usort($ads, function($first, $second) {
            return ($first->score() < $second->score()) ? 1 : -1;
        });
        
        $adsForIdealistUsers = [];
        foreach ($ads as $ad) {
            if ($ad->score() > Ad::CUT_OFF_MARK) {
                $adsForIdealistUsers[] = new PublicAd(
                    $ad->id(),
                    $ad->typology(),
                    $ad->description(),
                    $this->extractUrlPicturesFromAd($ad),
                    $ad->houseSize(),
                    $ad->gardenSize()
                );
            }
        }
        
        return $adsForIdealistUsers;
    }
    
    public function listAdsForQualityUsers(): array
    {
        $ads = $this->persistenceRepository->findAllAds();
        
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
        return $this->persistenceRepository->findAllAds();
    }
    
    public function update(array $adsList): void
    {
        $this->persistenceRepository->updateAds($adsList);
    }
    
    private function extractUrlPicturesFromAd(Ad $ad): array
    {
        $pictures = [];
        foreach ($ad->pictures() as $pictureId) {
            $pictures[] = $this->pictureRepository->findById($pictureId)->url();
        }
        
        return $pictures;
    }
}
