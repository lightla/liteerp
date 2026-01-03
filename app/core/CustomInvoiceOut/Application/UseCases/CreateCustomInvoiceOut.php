<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\CustomInvoiceOut\Application\DTOs\CreateCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;
use Core\CustomInvoiceOut\Infrastructure\Events\CustomInvoiceOutEvent;
use Illuminate\Support\Facades\DB;

class CreateCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::CREATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'CustomInvoiceOut'
            )
        );
        $dto = CreateCustomInvoiceOutRequest::fromArray($data);
        $create = $this->service->create($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::CREATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$data,
                    ...$create->toArray()
                ],
                module: 'CustomInvoiceOut'
            )
        );
        CustomInvoiceOutEvent::handle('create', [
            ...$data
        ]);
        DB::commit();

        return $data;
    }
}
