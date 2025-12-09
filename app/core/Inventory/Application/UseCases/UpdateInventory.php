<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Domain\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateInventory
{
    public function __construct(private InventoryService $service) {}

    public function handle(CreateInventoryRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch('erp.inventory.update', [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            ...$update->toArray()
        ]);
        DB::commit();
        return $update;
    }
}
