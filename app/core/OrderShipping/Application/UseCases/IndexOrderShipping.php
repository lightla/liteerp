<?php

namespace Core\Ordershipping\Application\UseCases;

use Core\Ordershipping\Domain\Services\OrderShippingService;

class IndexOrderShipping
{
    public function __construct(private OrderShippingService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}