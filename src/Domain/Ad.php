<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;

final class Ad
{
    public const FLAT = "FLAT";
    public const CHALET = "CHALET";
    public const GARAGE = "GARAGE";
    public const CUT_OFF_MARK = 40;
    
    private int $id;
    private string $typology;
    private string $description;
    private array $pictures;
    private int $houseSize;
    private ?int $gardenSize;
    private ?int $score;
    private ?DateTimeImmutable $irrelevantSince;
           
    public function __construct(
        int $id,
        string $typology,
        string $description,
        array $pictures,
        int $houseSize,
        ?int $gardenSize = null,
        ?int $score = null,
        ?DateTimeImmutable $irrelevantSince = null,
    ) {
        $this->id = $id;
        $this->typology = $typology;
        $this->description = $description;
        $this->pictures = $pictures;
        $this->houseSize = $houseSize;
        $this->gardenSize = $gardenSize;
        $this->score = $score;
        $this->irrelevantSince = $irrelevantSince;
    }
    
    public function id(): int
    {
        return $this->id;
    }
    
    public function typology(): string
    {
        return $this->typology;
    }
    
    public function description(): string
    {
        return $this->description;
    }
    
    public function pictures(): array
    {
        return $this->pictures;
    }
    
    public function houseSize(): int
    {
        return $this->houseSize;
    }
    
    public function gardenSize(): ?int
    {
        return $this->gardenSize;
    }
    
    public function score(): ?int
    {
        return $this->score;
    }
    
    public function irrelevantSince(): ?DateTimeImmutable
    {
        return $this->irrelevantSince;
    }
    
    public function winScore($points): void
    {
        if (($this->score + $points)  >= 100) {
            $this->score = 100;
        } else {
            $this->score = $this->score + $points;
        }
    }
    
    public function loseScore($points): void
    {
        if (($this->score - $points)  <= 0) {
            $this->score = 0;
        } else {
            $this->score = $this->score - $points;
        }
    }
    
    public function markAsIrrelevant(): void
    {
        $this->irrelevantSince = new DateTimeImmutable('now');
    }
}
