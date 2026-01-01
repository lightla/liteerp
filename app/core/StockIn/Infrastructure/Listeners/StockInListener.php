<?php

namespace Core\StockIn\Infrastructure\Listeners;

use Core\StockIn\Application\DTOs\CancelledStockInRequest;
use Core\StockIn\Application\DTOs\CheckForStockMovementInRequest;
use Core\StockIn\Application\UseCases\CancelledStockIn;
use Core\StockIn\Application\UseCases\CheckForStockMovementIn;
use Core\StockIn\Application\UseCases\CreateStockIn;
use Illuminate\Support\Facades\Event;

class StockInListener
{
    public function handle(
        CreateStockIn $createStockIn,
        CheckForStockMovementIn $checkForStockMovementIn,
        CancelledStockIn $cancelledStockIn
    ) {
        Event::listen('erp.invoicein.*', function (string $eventName, array $data)
        use ($createStockIn, $cancelledStockIn) {
            if ($eventName === 'erp.invoicein.approved') {
                $createStockIn->handle($data);
            } else if ($eventName === 'erp.invoicein.cancelled') {
                $cancelledStockIn->handle(CancelledStockInRequest::fromArray($data));
            }
        });
        Event::listen(
            'erp.stockmovementin.*',
            function (string $eventName, array $data)
            use ($checkForStockMovementIn) {
                if (
                    $eventName === 'erp.stockmovementin.update'
                    || $eventName === 'erp.stockmovementin.create'
                ) {
                    $checkForStockMovementIn->handle(CheckForStockMovementInRequest::fromArray([
                        'id' => $data['stock_in_id'],
                        'business_id' => $data['business_id'],
                        'user_id' => $data['user_id']
                    ]));
                }
            }
        );
    }
}
