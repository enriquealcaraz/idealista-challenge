<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\QualityListingUseCase;
use Exception;

final class QualityListingController
{
    private $qualityListing;
    
    public function __construct(QualityListingUseCase $qualityListing)
    {
        $this->qualityListing = $qualityListing;
    }
    
    public function __invoke(): JsonResponse
    {
        try {
            return new JsonResponse($this->qualityListing->__invoke());
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
