<?php

namespace Core\Customer\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use App\Supports\Hooks\HookDispatcher;
use Core\Customer\Application\DTOs\CreateCustomerRequest;
use Core\Customer\Domain\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateCustomer
{
    public function __construct(
        private CustomerService $service,
        private HookDispatcher $hooks
    ) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::CREATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'Customer'
            )
        );
        $dto = CreateCustomerRequest::fromArray($hooks);
        $create = $this->service->create($dto->toArray());
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::CREATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $create->toArray(),
                module: 'Customer'
            )
        );
        Event::dispatch("erp.customer.create", [
            ...$hooks,
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::CREATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $hooks,
                module: 'Customer'
            )
        );
        DB::commit();
        return $hooks;
    }
}
