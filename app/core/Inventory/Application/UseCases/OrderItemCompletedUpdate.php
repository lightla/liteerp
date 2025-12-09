<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Application\DTOs\OrderItemCompletedUpdateRequest;
use Core\Inventory\Application\DTOs\UpdateInventoryByIdRequest;
use Core\Inventory\Domain\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class OrderItemCompletedUpdate
{
    public function __construct(private InventoryService $service) {}

    public function handle(OrderItemCompletedUpdateRequest $dto)
    {
        DB::beginTransaction();

        foreach($dto->list as $key => $value) {
            $quantity = (float) ($value['buy_quantity']
            + $value['gift_quantity']
            + $value['compensation_quantity']
            + $value['conversion_quantity']);
            $adapter = UpdateInventoryByIdRequest::fromArray([
                'quantity'     => -abs($quantity),
                'reserved_qty' => -abs($quantity),
                'created_by'   => $dto->created_by,
                'business_id'  => $dto->business_id,
                'id'    => $value['inventory_id'],
                'user_id' => $dto->created_by
            ]);
            $update = $this->service->updateById($adapter->toArray());
            Event::dispatch('erp.inventory.update', [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                ...$update->toArray()
            ]);
        }
        DB::commit();
        return $update;
    }
}