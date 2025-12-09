<?php

namespace Core\Inventory\Application\UseCases;

use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Domain\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateInventory
{
    public function __construct(private InventoryService $service,
    private CreateActivityLog $createLog) {}

    public function handle(CreateInventoryRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch('erp.inventory.create',[
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            ...$create->toArray()
        ]);
        DB::commit();
        return $create;
    }
}