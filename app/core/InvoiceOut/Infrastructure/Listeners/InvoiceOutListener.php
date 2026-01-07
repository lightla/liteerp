<?php

namespace Core\InvoiceOut\Infrastructure\Listeners;

use Core\InvoiceOut\Application\DTOs\CreateInvoiceOutRequest;
use Core\InvoiceOut\Application\DTOs\UnapproveInvoiceOutByOrderCancelledRequest;
use Core\InvoiceOut\Application\UseCases\CreateInvoiceOut;
use Core\InvoiceOut\Application\UseCases\UnapproveInvoiceOutByOrderCancelled;
use Illuminate\Support\Facades\Event;

class InvoiceOutListener
{
    public function handle(CreateInvoiceOut $createInvoiceOut,
    UnapproveInvoiceOutByOrderCancelled $UnapproveInvoiceOutByOrderCancelled)
    {
        Event::listen(
            'erp.order.*',
            function (string $eventName, array $data) use ($UnapproveInvoiceOutByOrderCancelled) {
                if ($eventName === 'erp.order.cancelled') {
                    $UnapproveInvoiceOutByOrderCancelled->handle(
                        new UnapproveInvoiceOutByOrderCancelledRequest(
                            business_id: $data['business_id'],
                            order_id: $data['order_id'],
                            created_by: $data['user_id']
                        )
                    );
                }
            }
        );
        Event::listen(
            'erp.orderitem.*',
            function (string $eventName, array $data) use ($createInvoiceOut) {
                if ($eventName === 'erp.orderitem.summary') {
                    $createInvoiceOut->handle($data);
                } 
            }
        );
    }
}