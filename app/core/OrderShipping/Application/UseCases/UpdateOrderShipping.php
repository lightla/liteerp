<?php

namespace Core\OrderShipping\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\OrderShipping\Application\DTOs\CreateOrderShippingRequest;
use Core\OrderShipping\Domain\Services\OrderShippingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateOrderShipping
{
    public function __construct(private OrderShippingService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data)
    {

        DB::beginTransaction();
        $dto = CreateOrderShippingRequest::fromArray($data);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'OrderShipping'
            )
        );
        $update = $this->service->update($data);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$data,
                    ...$update->toArray()
                ],
                module: 'OrderShipping'
            )
        );
        Event::dispatch('erp.ordershipping.update',[
            ...$update->toArray(),
            'business_id' => $dto->business_id,
            'user_id' => $dto->created_by
        ]);
        DB::commit();
        return $data;
    }
}