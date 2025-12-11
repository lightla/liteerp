<?php

namespace Core\StockIn\Application\UseCases;

use Core\StockIn\Application\DTOs\IndexStockInRequest;
use Core\StockIn\Domain\Services\StockInService;
use Illuminate\Support\Facades\Event;

class IndexStockIn
{
    public function __construct(private StockInService $service) {}

    public function handle(IndexStockInRequest $dto)
    {
        Event::dispatch('erp.stockin.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        return $this->service->index($dto->toArray());
    }
}