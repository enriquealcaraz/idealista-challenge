<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface AdsRepository
{
    public function listAdsForIdealistUsers(): array;
    
    public function listAdsForQualityUsers(): array;
    
    public function listAll(): array;
    
    public function update(array $adsList): void;
}
