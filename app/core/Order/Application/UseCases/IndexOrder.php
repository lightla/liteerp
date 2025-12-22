<?php

namespace Core\Order\Application\UseCases;

use Core\Order\Application\DTOs\CreateOrderRequest;
use Core\Order\Application\DTOs\IndexOrderRequest;
use Core\Order\Domain\Services\OrderService;
use Illuminate\Support\Facades\Event;

class IndexOrder
{
    public function __construct(private OrderService $service) {}

    public function handle(IndexOrderRequest $dto)
    {
        Event::dispatch('erp.order.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        return $this->service->index($dto->toArray());
    }
}