<?php

namespace Core\StockIn\Application\UseCases;

use Core\Product\Application\UseCases\IndexProduct;
use Core\StockIn\Domain\Services\StockInService;

class ShowStockIn
{
    public function __construct(private StockInService $service) {}

    public function handle(array $dto)
    {
        $stock = $this->service->show($dto);
        return $stock;
    }
}