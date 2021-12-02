<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Ad;

interface CalculatePointsForPicture
{
    public function calculate(Ad $ad): Ad;
}
