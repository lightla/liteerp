<?php

namespace Core\OrderItem\Application\UseCases;

use Core\OrderItem\Application\DTOs\CreateOrderItemRequest;
use Core\OrderItem\Domain\Services\OrderItemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateOrderItem
{
    public function __construct(private OrderItemService $service) {}

    public function handle(CreateOrderItemRequest $dto)
    {
        DB::beginTransaction();
        /**
         * Orders
         */
        $item = $this->service->create($dto->toArray());
        Event::dispatch('erp.orderitem.create',[
            'user_id' => $dto->user_id,
            'business_id' => $dto->business_id,
            'inventory_id' => $item->inventory_id,
            'qty_change' => (float) ($item->buy_quantity
                + $item->gift_quantity
                + $item->compensation_quantity
                + $item->conversion_quantity),
            ...$item->toArray()
        ]);
        DB::commit();

        return $item;
    }
}
