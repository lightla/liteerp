<?php

namespace Core\StockMovementOut\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Application\UseCases\UpdateInventory;
use Core\StockMovementOut\Application\DTOs\CreateStockMovementOutRequest;
use Core\StockMovementOut\Domain\Services\StockMovementOutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateStockMovementOut
{
    public function __construct(
        private StockMovementOutService $service,
        private UpdateInventory $updateInventory
    ) {}

    public function handle(CreateStockMovementOutRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        // update inventory
        // $this->updateInventory->handle(CreateInventoryRequest::fromArray([
        //     'product_id' => $dto->product_id,
        //     'warehouse_id'  => $dto->warehouse_id,
        //     'reserved_qty' => $dto->qty_change,
        //     'user_id' => $dto->created_by,
        //     'business_id' => $dto->business_id
        // ]));
        Event::dispatch("erp.stockmovementout.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'product_id' => $dto->product_id,
            'warehouse_id'  => $dto->warehouse_id,
            'reserved_qty' => $dto->qty_change,
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}
