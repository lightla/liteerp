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
        if($update->isApproved() && !$entity->isApproved()) {
            Event::dispatch("erp.invoicein.approved", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_in_id' => $update->id,
            ]);
        } else {
            Event::dispatch("erp.invoicein.update", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_in_id' => $update->id,
            ]);
        }
        
        DB::commit();
        return $update;
    }
}
