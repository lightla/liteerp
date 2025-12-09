<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\UpdateInventoryByIdRequest;
use Core\Inventory\Domain\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateInventoryById
{
    public function __construct(private InventoryService $service) {}

    public function handle(UpdateInventoryByIdRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->updateById($dto->toArray());
        Event::dispatch('erp.inventory.update', [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            ...$update->toArray()
        ]);
        DB::commit();
        return $update;
    }
}
