<?php

namespace Core\InvoiceOut\Application\UseCases;

use Core\InvoiceOut\Application\DTOs\CreateInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateInvoiceOut
{
    public function __construct(
        private InvoiceOutService $service
    ) {}

    public function handle(CreateInvoiceOutRequest $dto)
    {
        DB::beginTransaction();
        $arrayData = $dto->toArray();
        $findInvoice = $this->service->findById($arrayData);
        $update = $this->service->update($arrayData);
        if($arrayData['approved'] === true && !$findInvoice->isApproved()) {
            Event::dispatch("erp.invoiceout.approved", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_out_id' => $update->id
            ]);  
        } else {
            Event::dispatch("erp.invoiceout.update", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_out_id' => $update->id
            ]);    
        }

        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => 'updated',
            'entity_type' => 'invoiceout',
            'entity_id' => $update->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => 'updated',
            'entity_type' => 'invoiceout',
            'entity_id' => $update->id,
            'chanels' => ['db']
        ]);
        
        DB::commit();
        return $update;
    }
}
