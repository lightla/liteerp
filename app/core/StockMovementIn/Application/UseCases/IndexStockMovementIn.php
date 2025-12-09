<?php

namespace Core\StockMovementIn\Application\UseCases;

use Core\StockMovementIn\Application\DTOs\IndexStockMovementInRequest;
use Core\StockMovementIn\Domain\Services\StockMovementInService;

class IndexStockMovementIn {
    public function __construct(private StockMovementInService $service){}
    public function handle(IndexStockMovementInRequest $data) {
        return $this->service->index($data->toArray());
    }

}