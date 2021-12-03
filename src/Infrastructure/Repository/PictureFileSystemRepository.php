<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\PersistenceRepository;
use App\Domain\Repository\PictureRepository;
use App\Domain\Picture;

final class PictureFileSystemRepository implements PictureRepository
{
    private PersistenceRepository $persistenceRepository;
    
    public function __construct(PersistenceRepository $persistenceRepository)
    {
        $this->persistenceRepository = $persistenceRepository;
    }
    
    public function findById($pictureId): ?Picture
    {
        $pictures = $this->persistenceRepository->findAllPictures();
        foreach($pictures as $picture) {
            if ($picture->id() == $pictureId) {
                return $picture;
            }
        }
        return null;
    }
}
