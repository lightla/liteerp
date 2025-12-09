<?php

namespace Core\OrderItem\Application\UseCases;
use Core\OrderItem\Domain\Services\OrderItemService;

class UpdateOrderItem
{
    public function __construct(private OrderItemService $service) {}

    public function handle(array $dto)
    {
        return $this->service->update($dto);
    }
}