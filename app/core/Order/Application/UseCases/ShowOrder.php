<?php

namespace Core\Order\Application\UseCases;

use Core\Order\Application\DTOs\CreateOrderRequest;
use Core\Order\Domain\Services\OrderService;

class ShowOrder
{
    public function __construct(private OrderService $service) {}

    public function handle(array $dto)
    {
        return $this->service->show($dto);
    }
}