<?php

namespace Core\Shipping\Application\UseCases;

use Core\Shipping\Application\DTOs\CreateShippingRequest;
use Core\Shipping\Domain\Services\ShippingService;

class IndexShipping
{
    public function __construct(private ShippingService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}