<?php

namespace Core\OrderShipping\Application\UseCases;

use Core\Order\Application\UseCases\FindOrderOneById;
use Core\OrderShipping\Application\DTOs\CreateOrderShippingRequest;
use Core\OrderShipping\Domain\Services\OrderShippingService;

class CreateOrderShipping
{
    public function __construct(private OrderShippingService $service) {}

    public function handle(CreateOrderShippingRequest $dto)
    {
        // create order shipping
        return $this->service->create($dto->toArray());
    }
}