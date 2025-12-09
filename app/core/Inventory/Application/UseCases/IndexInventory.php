<?php

namespace Core\Inventory\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Domain\Services\InventoryService;

class IndexInventory
{
    public function __construct(private InventoryService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}