<?php

namespace Core\StockOut\Application\UseCases;

use Core\StockOut\Application\DTOs\CreateStockOutRequest;
use Core\StockOut\Domain\Entities\StockOut;
use Core\StockOut\Domain\Services\StockOutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
class CreateStockOut
{
    public function __construct(private StockOutService $service) {}

    public function handle(CreateStockOutRequest $dto) : StockOut
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.stockout.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'order_id' => $dto->order_id
        ]);
        DB::commit();
        return $create;
    }
}