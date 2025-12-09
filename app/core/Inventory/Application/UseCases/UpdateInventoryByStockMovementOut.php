<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Application\DTOs\UpdateInventoryByStockMovementOutRequest;
use Core\Inventory\Domain\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateInventoryByStockMovementOut
{
    public function __construct(private InventoryService $service) {}

    public function handle(UpdateInventoryByStockMovementOutRequest $dto)
    {
        DB::beginTransaction();
        foreach ($dto->list as $key => $value) {
            $updateData = new CreateInventoryRequest(
                product_id: $value['product_id'],
                warehouse_id: $value['warehouse_id'],
                quantity: -abs($value['quantity']),
                reserved_qty: -abs($value['reserved_qty']),
                created_by: $dto->created_by,
                business_id: $dto->business_id
            );
            $update =$this->service->update($updateData->toArray());
            Event::dispatch('erp.inventory.update',[
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                ...$update->toArray()
            ]);
        }
        DB::commit();
        return;
    }
}
