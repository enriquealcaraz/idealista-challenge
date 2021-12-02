<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\PublicListingUseCase;

final class PublicListingController
{
    private $publicListing;
    
    public function __construct(PublicListingUseCase $publicListing)
    {
        $this->publicListing = $publicListing;
    }

    public function __invoke(): JsonResponse
    {        
        return new JsonResponse($this->publicListing->__invoke());
    }
}
