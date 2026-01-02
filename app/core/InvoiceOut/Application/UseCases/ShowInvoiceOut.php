<?php

namespace Core\InvoiceOut\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\InvoiceOut\Application\DTOs\ShowInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Illuminate\Support\Facades\Event;

class ShowInvoiceOut
{
    public function __construct(private InvoiceOutService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::SHOW,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'InvoiceOut'
            )
        );
        $dto = ShowInvoiceOutRequest::fromArray($data);
        Event::dispatch('erp.invoiceout.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        $show =  $this->service->show($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::SHOW,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$data,
                    ...$show 
                ],
                module: 'InvoiceOut'
            )
        );
        return $data;
    }
}