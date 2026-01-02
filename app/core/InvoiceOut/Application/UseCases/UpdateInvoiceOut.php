<?php

namespace Core\InvoiceOut\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\InvoiceOut\Application\DTOs\CreateInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateInvoiceOut
{
    public function __construct(
        private InvoiceOutService $service,
        private HookDispatcher $hooks
    ) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'InvoiceOut'
            )
        );
        $dto = CreateInvoiceOutRequest::fromArray($data);
        $arrayData = $dto->toArray();
        $findInvoice = $this->service->findById($arrayData);
        $update = $this->service->update($arrayData);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: [
                    ...$data,
                    ...$update->toArray()
                ],
                module: 'InvoiceOut'
            )
        );
        if($arrayData['approved'] === true && !$findInvoice->isApproved()) {
            Event::dispatch("erp.invoiceout.approved", [
                ...$data,
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_out_id' => $update->id
            ]);  
        } else {
            Event::dispatch("erp.invoiceout.update", [
                ...$data,
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
        return $data;
    }
}
