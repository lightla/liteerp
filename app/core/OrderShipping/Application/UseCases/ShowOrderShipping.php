<?php

namespace Core\OrderShipping\Application\UseCases;

use Core\OrderShipping\Domain\Services\OrderShippingService;

class ShowOrderShipping
{
    public function __construct(private OrderShippingService $service) {}

    public function handle(array $dto)
    {
        return $this->service->show($dto);
    }
}