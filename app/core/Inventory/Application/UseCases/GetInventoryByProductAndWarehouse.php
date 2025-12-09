<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\GetInventoryByProductWarehouseRequest;
use Core\Inventory\Domain\Entities\Inventory;
use Core\Inventory\Domain\Services\InventoryService;

class GetInventoryByProductAndWarehouse
{
    public function __construct(private InventoryService $service) {}

    public function handle(GetInventoryByProductWarehouseRequest $dto) : ?Inventory
    {
        return $this->service->getByOneByProductAndWarehouse($dto->toArray());
    }
}