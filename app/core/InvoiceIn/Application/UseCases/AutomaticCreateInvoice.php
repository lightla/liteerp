<?php

namespace Core\InvoiceIn\Application\UseCases;

use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class AutomaticCreateInvoice
{
    public function __construct(private InvoiceInService $service) {}

    public function handle(CreateInvoiceInRequest $dto)
    {
        DB::beginTransaction();
        if($this->service->getByPurchaseId($dto->toArray())) {
            return;
        }
        $create = $this->service->create($dto->toArray());
        Event::dispatch('erp.invoicein.create',[
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            ...$create->toArray()
        ]);
        DB::commit();
        return $create;
    }
}