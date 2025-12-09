<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Domain\Entities\Inventory;
use Core\Inventory\Domain\Services\InventoryService;

class FindInventoryById
{
    public function __construct(private InventoryService $service) {}

    public function handle(array $dto) : Inventory
    {
        return $this->service->findById($dto);
    }
}