<?php

namespace Core\Customer\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Customer\Application\DTOs\CreateCustomerRequest;
use Core\Customer\Domain\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateCustomer
{
    public function __construct(private CustomerService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'Customer'
            )
        );
        $dto = CreateCustomerRequest::fromArray($hooks);
        $update = $this->service->update($dto->toArray());
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: $update->toArray(),
                module: 'Customer'
            )
        );
        Event::dispatch("erp.customer.update", [
            ...$hooks,
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: $hooks,
                module: 'Customer'
            )
        );
        DB::commit();
        return $hooks;
    }
}