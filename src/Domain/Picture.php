<?php

declare(strict_types=1);

namespace App\Domain;

use JsonSerializable;

final class Picture implements JsonSerializable
{
    public const TYPE_HD = "HD";
    public const TYPE_SD = "SD";
    
    private int $id;
    private string $url;
    private string $quality;
            
    public function __construct(
        int $id,
        string $url,
        string $quality,
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->quality = $quality;
    }
    
    public function quality(): string
    {
        return $this->quality;
    }
    
    public function id(): int
    {
        return $this->id;
    }
    
    public function url(): string
    {
        return $this->url;
    }
    
    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id(),
            "url" => $this->url(),
            "quality" => $this->quality()
        ];
    }
}
