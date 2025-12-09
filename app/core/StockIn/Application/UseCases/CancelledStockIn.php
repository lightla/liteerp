<?php

namespace Core\StockIn\Application\UseCases;

use Core\StockIn\Application\DTOs\CancelledStockInRequest;
use Core\StockIn\Application\DTOs\CreateStockInRequest;
use Core\StockIn\Domain\Services\StockInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CancelledStockIn {
    public function __construct(private StockInService $service) {}

    public function handle(CancelledStockInRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->changeToCancelled($dto->toArray());
        Event::dispatch("erp.stockin.cancelled", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}