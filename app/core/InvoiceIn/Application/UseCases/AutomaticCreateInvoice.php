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
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => 'created',
            'entity_type' => 'invoicein',
            'entity_id' => $create->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => 'created',
            'entity_type' => 'invoicein',
            'entity_id' => $create->id,
            'chanels' => ['db']
        ]);
        DB::commit();
        return $create;
    }
}