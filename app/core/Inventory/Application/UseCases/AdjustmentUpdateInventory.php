<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\AdjustmentUpdateInventoryRequest;
use Core\Inventory\Domain\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class AdjustmentUpdateInventory
{
    public function __construct(private InventoryService $service) {}

    public function handle(AdjustmentUpdateInventoryRequest $dto)
    {
        DB::beginTransaction();
        $row = $this->service->getByOneByProductAndWarehouse($dto->toArray());
        if($row) {
            $update = $this->service->update($dto->toArray());
            Event::dispatch('erp.inventory.update', [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                ...$update->toArray()
            ]);
        } else {
            $create = $this->service->create($dto->toArray());
            Event::dispatch('erp.inventory.create', [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                ...$create->toArray()
            ]);
        }
        DB::commit();
    }
}
