<?php

namespace Core\StockIn\Application\UseCases;

use Core\StockIn\Application\DTOs\CreateStockInRequest;
use Core\StockIn\Domain\Services\StockInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateStockIn
{
    public function __construct(private StockInService $service) {}

    public function handle(CreateStockInRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.stockin.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}