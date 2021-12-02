<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Service\CalculatePointsForDescription;
use App\Domain\Ad;

final class ProcessCalculatePointsForDescription implements CalculatePointsForDescription
{
    private array $keyword = array("nuevo", "ático", "reformado", "céntrico", "luminoso");
    private string $specialChars = "áéÁñíó";
    
    public function calculate(Ad $ad): Ad
    {
        if (!empty($ad->description())) {
            $ad->winScore(5);
        }

        $wordCount = str_word_count($ad->description(), 0, $this->specialChars);
        if ($ad->typology() == Ad::FLAT) {            
            ($wordCount >= 29 && $wordCount <= 49) ? $ad->winScore(10) : null;            
            ($wordCount >= 50) ? $ad->winScore(30) : null;
        }
        
        if ($ad->typology() == Ad::CHALET && $wordCount > 50) {
            $ad->winScore(20);
        }
        
        $description = mb_strtolower($ad->description(), "UTF-8");
        foreach ($this->keyword as $keyword) {            
            (stripos($description, $keyword) !== false) ? $ad->winScore(5) : null;
        }

        return $ad;
    }
}
