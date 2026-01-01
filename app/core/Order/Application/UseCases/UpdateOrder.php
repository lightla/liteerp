<?php

namespace Core\Order\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Order\Application\DTOs\UpdateOrderRequest;
use Core\Order\Domain\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateOrder
{
    public function __construct(
        private OrderService $service, 
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
                payload: [
                    ...$data
                ],
                module: 'Order'
            )
        );
        $dto = UpdateOrderRequest::fromArray($data);
        $update = $this->service->update($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$data,
                    ...$update->toArray()
                ],
                module: 'Order'
            )
        );
        $notificationStatus = 'update';
        if($update->isApproved()) {
            Event::dispatch("erp.order.approved", [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'id' => $update->id,
                'order_id'     => $update->id,
            ]);  
            $notificationStatus = "approved";
        } else if($update->isCancelled()) {
            Event::dispatch("erp.order.cancelled", [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'id' => $update->id,
                'order_id'     => $update->id,
                'reason' => $dto->reason
            ]);
            $notificationStatus = "cancelled";
        } else {
            Event::dispatch("erp.order.update", [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'id' => $update->id,
                'order_id'     => $update->id,
            ]);
        }
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $notificationStatus,
            'entity_type' => 'order',
            'entity_id' => $update->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $notificationStatus,
            'entity_type' => 'order',
            'entity_id' => $update->id,
            'chanels' => ['db']
        ]);
        DB::commit();
        return $data;
    }
}
