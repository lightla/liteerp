<?php

namespace Core\Shipping\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Shipping\Application\DTOs\CreateShippingRequest;
use Core\Shipping\Domain\Services\ShippingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateShipping
{
    public function __construct(private ShippingService $service,
    private HookDispatcher $dispatch) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $data = $this->dispatch->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'Shipping'
            )
        );
        $dto = CreateShippingRequest::fromArray($data);
        $update = $this->service->update($dto->toArray());
        $data = $this->dispatch->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: $data,
                module: 'Shipping'
            )
        );
        Event::dispatch("erp.shipping.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}