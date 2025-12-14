<?php

namespace Core\StockOut\Application\UseCases;

use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Application\UseCases\UpdateInventory;
use Core\StockMovementOut\Application\UseCases\IndexWithLimitStockMovementOut;
use Core\StockOut\Application\DTOs\CreateStockOutRequest;
use Core\StockOut\Domain\Entities\StockOut;
use Core\StockOut\Domain\Services\StockOutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class UpdateStockOut
{
    public function __construct(
        private StockOutService $service,
    ) {}

    public function handle(CreateStockOutRequest $dto): StockOut
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        $statusNotify = 'updated';
        if($update->isCompleted()) {
            Event::dispatch("erp.stockout.completed", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'order_id' => $dto->order_id,
                'stock_out_id' => $update->id
            ]);
            $statusNotify = 'completed';
        } else if($update->isShipped()) {
            Event::dispatch("erp.stockout.shipped", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'order_id' => $dto->order_id,
                'stock_out_id' => $update->id
            ]);
            $statusNotify = 'shipped';
        } else {
            Event::dispatch("erp.stockout.update", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'order_id' => $dto->order_id
            ]);    
        }
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $statusNotify,
            'entity_type' => 'stockout',
            'entity_id' => $update->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $statusNotify,
            'entity_type' => 'stockout',
            'entity_id' => $update->id,
            'chanels' => ['db']
        ]);
        DB::commit();
        return $update;
    }
}
