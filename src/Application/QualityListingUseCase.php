<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Repository\AdsRepository;

class QualityListingUseCase
{
    private $adsRepository;
    
    public function __construct(AdsRepository $adsRepository) 
    {
        $this->adsRepository = $adsRepository;
    }
    
    public function __invoke(): array
    {
        return $this->adsRepository->listAdsForQualityUsers();
    }
}
