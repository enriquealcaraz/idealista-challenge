<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\CalculateScoreUseCase;


final class CalculateScoreController
{
    private $calculateScore;
    
    public function __construct(CalculateScoreUseCase $calculateScore)
    {
        $this->calculateScore = $calculateScore;
    }
    
    public function __invoke(): JsonResponse
    {
        $this->calculateScore->__invoke();
        return new JsonResponse(null, JsonResponse::HTTP_OK);
    }
}
