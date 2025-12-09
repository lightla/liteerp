<?php

namespace Core\StockIn\Application\UseCases;

use Core\StockIn\Application\DTOs\CreateStockInRequest;
use Core\StockIn\Domain\Services\StockInService;

class IndexStockIn
{
    public function __construct(private StockInService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}