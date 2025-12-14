<?php

namespace Core\Purchase\Application\UseCases;

use App\Exceptions\BadException;
use Core\Purchase\Application\DTOs\CreatePurchaseRequest;
use Core\PurchaseItem\Application\UseCases\IndexPurchaseItem;
use Core\Purchase\Domain\Services\PurchaseService;
use Core\Purchase\Domain\Entities\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class UpdatePurchase
{
    public function __construct(private PurchaseService $service, 
    private IndexPurchaseItem $purchaseItem) {}

    public function handle(CreatePurchaseRequest $dto): Purchase
    {
        DB::beginTransaction();

        $update = $this->service->update($dto->toArray());

        /**
         * Check items 
         */
        $pItem = $this->purchaseItem->handle([
            ...$dto->toArray(),
            'purchase_id' => $dto->id
        ]);
        if(count($pItem) === 0) {
            throw new BadException(__("You has not yet add product"));
        }
        
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
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
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
