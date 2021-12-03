<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\PublicListingUseCase;
use Exception;

final class PublicListingController
{
    private $publicListing;
    
    public function __construct(PublicListingUseCase $publicListing)
    {
        $this->publicListing = $publicListing;
    }

    public function __invoke(): JsonResponse
    {
        try {
            return new JsonResponse($this->publicListing->__invoke(), JsonResponse::HTTP_OK);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
