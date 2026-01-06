<?php

namespace Core\InventoryAdjustment\Application\UseCases;

use Core\InventoryAdjustment\Application\DTOs\CreateInventoryAdjustmentRequest;
use Core\InventoryAdjustment\Domain\Services\InventoryAdjustmentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateInventoryAdjustment
{
    public function __construct(private InventoryAdjustmentService $service) {}

    public function handle(CreateInventoryAdjustmentRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.inventoryadjustment.create", [
            'product_id' => $create->product_id,
            'warehouse_id' => $create->warehouse_id,
            'quantity' => $create->qty_adjusted,
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}