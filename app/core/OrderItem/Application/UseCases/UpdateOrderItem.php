<?php

namespace Core\OrderItem\Application\UseCases;

use Core\OrderItem\Application\DTOs\CreateOrderItemRequest;
use Core\OrderItem\Domain\Services\OrderItemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateOrderItem
{
    public function __construct(private OrderItemService $service) {}

    public function handle(CreateOrderItemRequest $dto)
    {
        DB::beginTransaction();
        $oldData = $this->service->findById($dto->toArray());
        $old_qty_change = (float) ($oldData->buy_quantity
                + $oldData->gift_quantity
                + $oldData->compensation_quantity
                + $oldData->conversion_quantity);
        $update = $this->service->update($dto->toArray());
        $qty_change = (float) ($update->buy_quantity
                + $update->gift_quantity
                + $update->compensation_quantity
                + $update->conversion_quantity);
        
        Event::dispatch('erp.orderitem.update',[
            'user_id' => $dto->user_id,
            'business_id' => $dto->business_id,
            'inventory_id' => $update->inventory_id,
            'qty_change' => (float) ($qty_change - $old_qty_change),
            ...$update->toArray()
        ]);
        DB::commit();
    }
}