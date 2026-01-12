<?php

namespace Core\OrderItem\Application\UseCases;

use Core\OrderItem\Application\DTOs\DeleteOrderItemRequest;
use Core\OrderItem\Domain\Services\OrderItemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteOrderItem
{
    public function __construct(private OrderItemService $service) {}

    public function handle(DeleteOrderItemRequest $dto)
    {
        DB::beginTransaction();
        $delete = $this->service->delete($dto->toArray());
        $qty_change = (float) ($delete->buy_quantity
                + $delete->gift_quantity
                + $delete->compensation_quantity
                + $delete->conversion_quantity);
        Event::dispatch('erp.orderitem.delete',[
            'user_id' => $dto->user_id,
            'business_id' => $dto->business_id,
            'inventory_id' => $delete->inventory_id,
            'qty_change' => -abs($qty_change),
            ...$delete->toArray()
        ]);
        DB::commit();
        return $delete;
    }
}