<?php

namespace Core\StockMovementOut\Application\UseCases;

use Core\StockMovementOut\Application\DTOs\CreateStockMovementOutRequest;
use Core\StockMovementOut\Domain\Services\StockMovementOutService;

class FindByIdStockMovementOut
{
    public function __construct(private StockMovementOutService $service) {}

    public function handle(CreateStockMovementOutRequest $dto)
    {
        return $this->service->findById($dto->toArray());
    }
}