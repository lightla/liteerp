<?php

namespace Core\InvoiceIn\Infrastructure\Listeners;

use Core\InvoiceIn\Application\DTOs\ChangeToUnapprovedRequest;
use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Application\UseCases\AutomaticCreateInvoice;
use Core\InvoiceIn\Application\UseCases\UnapprovedInvoiceIn;
use Illuminate\Support\Facades\Event;

class InvoiceInListener
{
    public function __construct() {}
    public function handle(
        AutomaticCreateInvoice $AutomaticCreateInvoice,
        UnapprovedInvoiceIn $UnapprovedInvoiceIn
    ) {
        Event::listen('erp.purchase.*', function (string $eventName, array $data)
        use ($AutomaticCreateInvoice, $UnapprovedInvoiceIn) {
            if ($eventName === 'erp.purchase.approved') {
                $AutomaticCreateInvoice->handle(CreateInvoiceInRequest::fromArray([
                    'purchase_id' => $data['id'],
                    ...$data
                ]));
            } else if ($eventName === 'erp.purchase.cancelled') {
                $UnapprovedInvoiceIn->handle(new ChangeToUnapprovedRequest(
                    business_id: $data['business_id'],
                    purchase_id: $data['id'],
                    created_by: $data['user_id']
                ));
            }
        });
    }
}
