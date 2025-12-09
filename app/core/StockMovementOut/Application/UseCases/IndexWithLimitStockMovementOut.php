<?php

namespace Core\StockMovementOut\Application\UseCases;

use Core\StockMovementOut\Application\DTOs\CreateStockMovementOutRequest;
use Core\StockMovementOut\Domain\Services\StockMovementOutService;

class IndexWithLimitStockMovementOut
{
    public function __construct(private StockMovementOutService $service) {}

    public function handle(array $dto)
    {
        return $this->service->indexWithLimit($dto);
    }
}