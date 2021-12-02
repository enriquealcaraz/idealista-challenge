<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Service\CalculatePointsForAdCompleted;
use App\Domain\Ad;

final class ProcessCalculatePointsForAdCompleted implements CalculatePointsForAdCompleted
{
    private const POINTS = 40;
    
    public function calculate(Ad $ad): Ad
    {
        if (!empty($ad->description()) 
            && count($ad->pictures()) >= 1
            && $ad->typology() == Ad::FLAT 
            && $ad->houseSize() > 0    
        ) {
            $ad->winScore(self::POINTS);
        }
        
        if (!empty($ad->description()) 
            && count($ad->pictures()) >= 1
            && $ad->typology() == Ad::CHALET 
            && $ad->houseSize() > 0
            && $ad->gardenSize() != null
        ) {
            $ad->winScore(self::POINTS);
        }
        
        if ($ad->typology() == Ad::GARAGE && count($ad->pictures()) >= 1) {
            $ad->winScore(self::POINTS);
        }
               
        if ($ad->score() < Ad::CUT_OFF_MARK) {
            $ad->markAsIrrelevant();
        }

        return $ad;
    }
}
