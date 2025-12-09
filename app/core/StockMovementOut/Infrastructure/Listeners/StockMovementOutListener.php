<?php

namespace Core\StockMovementOut\Infrastructure\Listeners;

use Core\StockMovementOut\Application\DTOs\CreateManyStockMovementOutRequest;
use Core\StockMovementOut\Application\UseCases\CreateManyStockMovementOut;
use Illuminate\Support\Facades\Event;

class StockMovementOutListener
{
    public function handle(
        CreateManyStockMovementOut $CreateManyStockMovementOut
    ) {
        Event::listen(
            'erp.orderitem.*',
            function (string $eventName, array $orderItems) use ($CreateManyStockMovementOut) {

                if ($eventName === 'erp.orderitem.completed') {
                    $CreateManyStockMovementOut->handle(
                        CreateManyStockMovementOutRequest::fromArray($orderItems)
                    );
                }
            }
        );
    }
}
