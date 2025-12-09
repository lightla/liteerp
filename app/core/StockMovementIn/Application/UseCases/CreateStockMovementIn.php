<?php

namespace Core\StockMovementIn\Application\UseCases;

use Core\StockMovementIn\Application\DTOs\CreateStockMovementInRequest;
use Core\StockMovementIn\Domain\Services\StockMovementInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
class CreateStockMovementIn
{
    public function __construct(
        private StockMovementInService $service
    ) {}

    public function handle(CreateStockMovementInRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.stockmovementin.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'purchase_item_id' => $dto->purchase_item_id
        ]);
        DB::commit();
        return $create;
    }
}
