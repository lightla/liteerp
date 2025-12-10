<?php

namespace Core\OrderShipping\Application\UseCases;

use Core\OrderShipping\Domain\Services\OrderShippingService;

class IndexOrderShipping
{
    public function __construct(private OrderShippingService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}