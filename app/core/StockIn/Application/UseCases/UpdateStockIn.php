<?php

namespace Core\StockIn\Application\UseCases;

use Core\StockIn\Application\DTOs\CreateStockInRequest;
use Core\StockIn\Domain\Services\StockInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateStockIn
{
    public function __construct(private StockInService $service) {}

    public function handle(CreateStockInRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        if ($update->isReceived()) {
            Event::dispatch("erp.stockin.received", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id
            ]);
        } else {
            Event::dispatch("erp.stockin.update", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id
            ]);
        }
        DB::commit();
        return $update;
    }
}
