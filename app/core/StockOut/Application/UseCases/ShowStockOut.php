<?php

namespace Core\StockOut\Application\UseCases;

use Core\StockOut\Application\DTOs\CreateStockOutRequest;
use Core\StockOut\Domain\Services\StockOutService;

class ShowStockOut
{
    public function __construct(private StockOutService $service) {}

    public function handle(array $dto) : array
    {
        return $this->service->show($dto);
    }
}