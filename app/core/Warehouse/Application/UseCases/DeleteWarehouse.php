<?php

namespace Core\Warehouse\Application\UseCases;

use Core\Warehouse\Application\DTOs\DeleteWarehouseRequest;
use Core\Warehouse\Domain\Services\WarehouseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteWarehouse
{
    public function __construct(private WarehouseService $service) {}

    public function handle(DeleteWarehouseRequest $dto)
    {
        DB::beginTransaction();
        Event::dispatch("erp.warehouse.delete", [
            ...$dto->toArray(),
            'business_id' => $dto->business_id,
            'user_id' => $dto->created_by
        ]);
        $delete = $this->service->delete($dto->toArray());
        DB::commit();
        return $delete;
    }
}
