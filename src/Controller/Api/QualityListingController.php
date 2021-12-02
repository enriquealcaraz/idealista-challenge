<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\QualityListingUseCase;

final class QualityListingController
{
    private $qualityListing;
    
    public function __construct(QualityListingUseCase $qualityListing)
    {
        $this->qualityListing = $qualityListing;
    }
    
    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->qualityListing->__invoke());
    }
}
