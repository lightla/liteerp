<?php

namespace Core\StockMovementOut\Application\UseCases;

use Core\StockMovementOut\Application\DTOs\ComletedStockMovementOutRequest;
use Core\StockMovementOut\Domain\Services\StockMovementOutService;
use Illuminate\Support\Facades\Event;

class ComletedStockMovementOut
{
    public function __construct(private StockMovementOutService $service) {}

    public function handle(ComletedStockMovementOutRequest $dto)
    {
        $index = $this->service->index($dto->toArray());
        Event::dispatch('erp.stockmovementout.completed',[
            'list' => $index,
            'business_id' => $dto->business_id,
            'user_id' => $dto->created_by
        ]);
        return $index;
    }
}