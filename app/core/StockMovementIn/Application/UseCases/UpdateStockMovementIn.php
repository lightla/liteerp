<?php

namespace Core\StockMovementIn\Application\UseCases;

use App\Exceptions\BadException;
use App\Jobs\CreateNotificationJob;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Application\UseCases\CreateInventory;
use Core\Inventory\Application\UseCases\FindOneInventoryByProductAndWarehouse;
use Core\Inventory\Application\UseCases\UpdateInventory;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Core\PurchaseItem\Application\UseCases\FindPurchaseItemById;
use Core\StockMovementIn\Application\DTOs\CreateStockMovementInRequest;
use Core\StockMovementIn\Domain\Services\StockMovementInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class UpdateStockMovementIn
{
    public function __construct(
        private StockMovementInService $service,
    ) {}

    public function handle(CreateStockMovementInRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch("erp.stockmovementin.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}
