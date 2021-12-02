<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Infrastructure\Persistence\InFileSystemPersistence;
use App\Domain\Repository\PictureRepository;
use App\Domain\Picture;

final class PictureFileSystemRepository implements PictureRepository
{
    private InFileSystemPersistence $inFileSystemPersistence;
    
    public function __construct(InFileSystemPersistence $inFileSystemPersistence)
    {
        $this->inFileSystemPersistence = $inFileSystemPersistence;
    }
    
    public function findById($pictureId): ?Picture
    {
        $pictures = $this->inFileSystemPersistence->findAllPictures();
        foreach($pictures as $picture) {
            if ($picture->id() == $pictureId) {
                return $picture;
            }
        }
        return null;
    }
}
