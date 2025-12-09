<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\GetInventoryByIdRequest;
use Core\Inventory\Domain\Entities\Inventory;
use Core\Inventory\Domain\Services\InventoryService;

class GetInventoryById
{
    public function __construct(private InventoryService $service) {}

    public function handle(GetInventoryByIdRequest $dto) : ?Inventory
    {
        return $this->service->getById($dto->toArray());
    }
}