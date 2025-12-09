<?php

namespace Core\OrderItem\Application\UseCases;
use Core\OrderItem\Domain\Services\OrderItemService;
use Core\Order\Application\UseCases\FindOneById;

class IndexOrderItem
{
    public function __construct(private OrderItemService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}