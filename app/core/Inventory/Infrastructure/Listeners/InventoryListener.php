<?php

namespace Core\Inventory\Infrastructure\Listeners;

use Core\Inventory\Application\DTOs\AdjustmentUpdateInventoryRequest;
use Core\Inventory\Application\DTOs\OrderItemCancelledUpdateRequest;
use Core\Inventory\Application\DTOs\OrderItemCompletedUpdateRequest;
use Core\Inventory\Application\DTOs\UpdateInventoryByIdRequest;
use Core\Inventory\Application\DTOs\UpdateInventoryByStockMovementInRequest;
use Core\Inventory\Application\UseCases\OrderItemCompletedUpdate;
use Core\Inventory\Application\UseCases\AdjustmentUpdateInventory;
use Core\Inventory\Application\UseCases\OrderItemCancelledUpdate;
use Core\Inventory\Application\UseCases\UpdateInventoryById;
use Core\Inventory\Application\UseCases\UpdateInventoryByStockMovementIn;
use Illuminate\Support\Facades\Event;

class InventoryListener
{
    public function handle(
        UpdateInventoryById $UpdateInventoryById,
        UpdateInventoryByStockMovementIn $UpdateInventoryByStockMovementIn,
        OrderItemCompletedUpdate $OrderItemCompletedUpdate,
        AdjustmentUpdateInventory $AdjustmentUpdateInventory,
        OrderItemCancelledUpdate $OrderItemCancelledUpdate
    ) {
        Event::listen(
            "erp.stockmovementin.*",
            function (string $eventName, array $data) use (
                $UpdateInventoryByStockMovementIn
            ) {
                if ($eventName === 'erp.stockmovementin.completed') {
                    $dto = UpdateInventoryByStockMovementInRequest::fromArray($data);
                    $UpdateInventoryByStockMovementIn->handle($dto);
                }
            }
        );
        Event::listen(
            "erp.inventoryadjustment.*",
            function (string $eventName, array $data) use($AdjustmentUpdateInventory) {
                if($eventName === 'erp.inventoryadjustment.create') {
                    $AdjustmentUpdateInventory
                        ->handle(AdjustmentUpdateInventoryRequest::fromArray($data));
                }
            }
        );

        Event::listen('erp.orderitem.*',
            function(string $eventName, array $data) 
                use($OrderItemCompletedUpdate,
                    $UpdateInventoryById,
                    $OrderItemCancelledUpdate) {
                if($eventName === 'erp.orderitem.completed') {
                   $OrderItemCompletedUpdate
                    ->handle(OrderItemCompletedUpdateRequest::fromArray($data));
                }
                if($eventName === 'erp.orderitem.cancelled') {
                   $OrderItemCancelledUpdate
                    ->handle(OrderItemCancelledUpdateRequest::fromArray($data));
                }
                if($eventName === 'erp.orderitem.create') {
                   $UpdateInventoryById
                    ->handle(UpdateInventoryByIdRequest::fromArray([
                        'id' => $data['inventory_id'],
                        'reserved_qty' => $data['qty_change'],
                        'user_id' => $data['user_id'],
                        'business_id' => $data['business_id']
                    ]));
                }
            });
    }
}
