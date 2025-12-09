<?php

namespace Core\OrderItem\Application\UseCases;
use Core\OrderItem\Domain\Services\OrderItemService;
use Core\OrderItem\Application\DTOs\CompletedOrderItemRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class CompletedOrderItem
{
    public function __construct(private OrderItemService $service) {}

    public function handle(CompletedOrderItemRequest $dto)
    {
        $list = $this->service->indexForStockMovementOut($dto->toArray());
        Event::dispatch('erp.orderitem.completed',[
            'business_id' => $dto->business_id,
            'user_id'   => $dto->created_by,
            'order_id'  => $dto->order_id,
            'list' => $list,
            'stock_out_id' => $dto->stock_out_id
        ]);
    }
}