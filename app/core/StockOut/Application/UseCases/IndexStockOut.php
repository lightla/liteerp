<?php

namespace Core\StockOut\Application\UseCases;

use Core\StockOut\Application\DTOs\IndexStockOutRequest;
use Core\StockOut\Domain\Services\StockOutService;
use Illuminate\Support\Facades\Event;

class IndexStockOut
{
    public function __construct(private StockOutService $service) {}

    public function handle(IndexStockOutRequest $dto) : array
    {
        Event::dispatch('erp.stockout.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        return $this->service->index($dto->toArray());
    }
}