<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Picture;

interface PictureRepository
{
    public function findById($pictureId): ?Picture;
}
