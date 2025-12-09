<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Application\DTOs\GetInventoryByProductWarehouseRequest;
use Core\Inventory\Application\DTOs\UpdateInventoryByStockMovementInRequest;
use Core\Inventory\Domain\Services\InventoryService;

class UpdateInventoryByStockMovementIn
{
    public function __construct(private InventoryService $service) {}

    public function handle(UpdateInventoryByStockMovementInRequest $dto)
    {
        foreach ($dto->list as $key => $value) {
            $find = new GetInventoryByProductWarehouseRequest(
                product_id: $value['product_id'],
                warehouse_id: $value['warehouse_id'],
                business_id: $dto->business_id
            );
            $row = $this->service->getByOneByProductAndWarehouse($find->toArray());

            $adapter = CreateInventoryRequest::fromArray([
                    'product_id' => $value['product_id'],
                    'warehouse_id' => $value['warehouse_id'],
                    'business_id' => $dto->business_id,
                    'quantity' => $value['qty_change'],
                    'user_id' => $dto->created_by
                ]);
            if (!$row) {
                $this->service->create($adapter->toArray());
            } else {
                $this->service->update($adapter->toArray());
            }
        }
        return;
    }
}
