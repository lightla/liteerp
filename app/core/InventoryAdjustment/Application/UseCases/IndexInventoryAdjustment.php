<?php

namespace Core\InventoryAdjustment\Application\UseCases;

use Core\InventoryAdjustment\Application\DTOs\CreateInventoryAdjustmentRequest;
use Core\InventoryAdjustment\Domain\Services\InventoryAdjustmentService;

class IndexInventoryAdjustment
{
    public function __construct(private InventoryAdjustmentService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}