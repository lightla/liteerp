<?php

namespace Core\StockMovementIn\Infrastructure\Listeners;

use Core\StockMovementIn\Application\DTOs\IndexStockMovementInRequest;
use Core\StockMovementIn\Application\UseCases\CompleteStockMovementIn;
use Core\StockMovementIn\Application\UseCases\IndexStockMovementIn;
use Illuminate\Support\Facades\Event;

class StockMovementInListener
{
    public function handle(CompleteStockMovementIn $completeStockMovementIn)
    {
        Event::listen(
            "erp.stockin.*",
            function (string $eventName, array $data) use ($completeStockMovementIn) {
                if ($eventName === 'erp.stockin.received') {
                    $completeStockMovementIn->handle(new IndexStockMovementInRequest(
                        business_id: $data['business_id'],
                        created_by: $data['user_id'],
                        stock_in_id: $data['id']
                    ));
                }
            }
        );
    }
}
