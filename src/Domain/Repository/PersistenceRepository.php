<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface PersistenceRepository
{
    public function findAllAds(): array;
    
    public function findAllPictures(): array;
    
    public function updateAds(array $adsList): void;    
}
