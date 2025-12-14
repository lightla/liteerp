<?php

namespace Core\InvoiceIn\Application\UseCases;

use Core\InvoiceIn\Application\DTOs\ChangeToUnapprovedRequest;
use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UnapprovedInvoiceIn
{
    public function __construct(
        private InvoiceInService $service
    ) {}

    public function handle(ChangeToUnapprovedRequest $dto)
    {
    
        $invoice = $this->service->getByPurchaseId($dto->toArray());
        if(!$invoice) {
            /**
             * If System don't automatic create invoice 
             * So we don't need continue 
             */
            return;
        }
        /**
         * Is UnApproved 
         */
        if(!$invoice->isApproved()) {
            return;
        }
        DB::beginTransaction();
        $update = $this->service->changeToUnApproved($dto->toArray());
        
        Event::dispatch("erp.invoicein.cancelled", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'invoice_in_id' => $update->id,
        ]);
        DB::commit();
        return $update;
    }
}
