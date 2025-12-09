<?php

namespace Core\Warehouse\Application\UseCases;

use Core\Warehouse\Application\DTOs\IndexWarehouseRequest;
use Core\Warehouse\Domain\Services\WarehouseService;
use Illuminate\Support\Facades\Event;

class IndexWarehouse
{
    public function __construct(private WarehouseService $service) {}

    public function handle(IndexWarehouseRequest $dto)
    {
        $index = $this->service->index($dto->toArray());
        return $index;
    }
}
