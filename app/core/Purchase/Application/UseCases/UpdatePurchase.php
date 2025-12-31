<?php

namespace Core\Purchase\Application\UseCases;

use App\Exceptions\BadException;
use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Purchase\Application\DTOs\UpdatePurchaseRequest;
use Core\PurchaseItem\Application\UseCases\IndexPurchaseItem;
use Core\Purchase\Domain\Services\PurchaseService;
use Core\Purchase\Domain\Entities\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class UpdatePurchase
{
    public function __construct(private PurchaseService $service,
    private HookDispatcher $hooks) {}

    public function handle(array $data): Purchase
    {
        DB::beginTransaction();
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'Purchase'
            )
        );
        $dto = UpdatePurchaseRequest::fromArray($data);
        $update = $this->service->update($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: $data,
                module: 'Purchase'
            )
        );
        if($update->isApproved()) {
            $forInvoice = $this->service->show($dto->toArray());
            $updateData = [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                ...$update->toArray(),
                ...$forInvoice
            ];
            Event::dispatch("erp.purchase.approved", $updateData);
        } else if($update->isDraft()) {
            $updateData = [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                ...$update->toArray()
            ];
            Event::dispatch("erp.purchase.update", $updateData);
        } else if($update->isRequested()) {
            $updateData = [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                ...$update->toArray()
            ];
            Event::dispatch("erp.purchase.requested", $updateData);
        } else if($update->isCancelled()){
            $updateData = [
                'reason' => $dto->reason,
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'purchase_id' => $update->id,
                ...$update->toArray()
            ];
            Event::dispatch("erp.purchase.cancelled", $updateData);
        }
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $update->getStatus(),
            'entity_type' => 'purchase',
            'entity_id' => $update->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $update->getStatus(),
            'entity_type' => 'purchase',
            'entity_id' => $update->id,
            'chanels' => ['db']
        ]);
        DB::commit();
        return $update;
    }
}
