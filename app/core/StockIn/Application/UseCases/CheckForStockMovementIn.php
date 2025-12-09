<?php

namespace Core\StockIn\Application\UseCases;

use App\Exceptions\BadException;
use Core\StockIn\Application\DTOs\CheckForStockMovementInRequest;
use Core\StockIn\Domain\Services\StockInService;

class CheckForStockMovementIn
{
    public function __construct(private StockInService $service) {}

    public function handle(CheckForStockMovementInRequest $dto)
    {
        $stock = $this->service->findById($dto->toArray());
        if($stock->isReceived()) {
            throw new BadException(__("Stock in has been received, you can not update data"));
        }
        if($stock->isCancelled()) {
            throw new BadException(__("Stock in has been cancelled, you can not update data"));
        }
        return $stock;
    }
}