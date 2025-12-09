<?php

namespace Core\Warehouse\Application\UseCases;
use Core\Warehouse\Application\DTOs\CreateWarehouseRequest;
use Core\Warehouse\Domain\Services\WarehouseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateWarehouse
{
    public function __construct(private WarehouseService $service) {}

    public function handle(CreateWarehouseRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.warehouse.create", [
            ...$create->toArray(),
            'business_id' => $dto->business_id,
            'user_id' => $dto->created_by
        ]);
        DB::commit();
        return $create;
    }
}
