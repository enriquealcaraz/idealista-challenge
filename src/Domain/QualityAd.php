<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;
use JsonSerializable;

final class QualityAd implements JsonSerializable
{
    private int $id;
    private string $typology;
    private string $description;
    private array $pictureUrls;
    private int $houseSize;
    private ?int $gardenSize;
    private ?int $score;
    private ?DateTimeImmutable $irrelevantSince;
            
    public function __construct(
        int $id,
        string $typology,
        string $description,
        array $pictureUrls,
        int $houseSize,
        ?int $gardenSize = null,
        ?int $score = null,
        ?DateTimeImmutable $irrelevantSince = null,
    ) {
        $this->id = $id;
        $this->typology = $typology;
        $this->description = $description;
        $this->pictureUrls = $pictureUrls;
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
    
    public function pictureUrls(): array
    {
        return $this->pictureUrls;
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
    
    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id(),
            "typology" => $this->typology(),
            "description" => $this->description(),
            "picturesUrls" => $this->pictureUrls(),
            "houseSize" => $this->houseSize(),
            "gardenSize" => $this->gardenSize(),
            "score" => $this->score(),
            "irrelevantSince" => $this->irrelevantSince()
        ];
    }
}
