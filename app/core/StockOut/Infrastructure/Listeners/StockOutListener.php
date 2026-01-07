<?php

namespace Core\StockOut\Infrastructure\Listeners;

use Core\StockOut\Application\DTOs\CancelledStockOutByOrderCancelledRequest;
use Core\StockOut\Application\DTOs\CreateStockOutRequest;
use Core\StockOut\Application\UseCases\CancelledStockOutByOrderCancelled;
use Core\StockOut\Application\UseCases\CreateStockOut;
use Illuminate\Support\Facades\Event;

class StockOutListener
{
    public function handle(
        CreateStockOut $CreateStockOut,
        CancelledStockOutByOrderCancelled $CancelledStockOutByOrderCancelled
    ) {
        Event::listen(
            'erp.invoiceout.*',
            function (string $eventName, array $data)
            use ($CreateStockOut, $CancelledStockOutByOrderCancelled) {
                if ($eventName === 'erp.invoiceout.approved') {
                    $CreateStockOut->handle($data);
                } else if ($eventName === 'erp.invoiceout.unapproved') {
                    $CancelledStockOutByOrderCancelled->handle(
                        CancelledStockOutByOrderCancelledRequest::fromArray([
                            'invoice_out_id' => $data['invoice_out_id'],
                            'business_id' => $data['business_id'],
                            'user_id'  => $data['user_id'],
                            'id'          => $data['id'],
                            'order_id' => $data['order_id']
                        ])
                    );
                }
            }
        );
    }
}
