<?php

namespace Core\Ordershipping\Application\UseCases;

use Core\Order\Application\UseCases\FindOrderOneById;
use Core\Ordershipping\Application\DTOs\CreateOrderShippingRequest;
use Core\Ordershipping\Domain\Services\OrderShippingService;

class CreateOrderShipping
{
    public function __construct(private OrderShippingService $service) {}

    public function handle(CreateOrderShippingRequest $dto)
    {
        // create order shipping
        return $this->service->create($dto->toArray());
    }
}