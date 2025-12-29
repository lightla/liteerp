<?php

namespace Core\Shipping\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Shipping\Application\DTOs\DeleteShippingRequest;
use Core\Shipping\Domain\Services\ShippingService;
use Illuminate\Support\Facades\Event;

class DeleteShipping
{
    public function __construct(private ShippingService $service,
    private HookDispatcher $dispatch) {}

    public function handle(array $data)
    {
        $data = $this->dispatch->dispatch(
            new HookContext(
                action: HookAction::DELETE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'Shipping'
            )
        );
        $dto = DeleteShippingRequest::fromArray($data);
        $data = $this->dispatch->dispatch(
            new HookContext(
                action: HookAction::DELETE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: $data,
                module: 'Shipping'
            )
        );
        Event::dispatch("erp.shipping.delete", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $this->service->delete($dto->toArray());
    }
}