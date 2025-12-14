<?php

namespace Core\InvoiceIn\Application\UseCases;

use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateInvoiceIn
{
    public function __construct(
        private InvoiceInService $service
    ) {}

    public function handle(CreateInvoiceInRequest $dto)
    {
        DB::beginTransaction();
        $entity = $this->service->findById($dto->toArray());
        $update = $this->service->update($dto->toArray());
        $status = 'update';
        if($update->isApproved() && !$entity->isApproved()) {
            Event::dispatch("erp.invoicein.approved", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_in_id' => $update->id,
            ]);
            $status = 'approved';
        } else {
            Event::dispatch("erp.invoicein.update", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_in_id' => $update->id,
            ]);
        }
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $status,
            'entity_type' => 'invoicein',
            'entity_id' => $update->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $status,
            'entity_type' => 'invoicein',
            'entity_id' => $update->id,
            'chanels' => ['db']
        ]);
        
        DB::commit();
        return $update;
    }
}
