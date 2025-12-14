<?php

namespace Core\Purchase\Application\UseCases;

use Core\Purchase\Application\DTOs\CreatePurchaseRequest;
use Core\Purchase\Domain\Services\PurchaseService;
use Core\Purchase\Domain\Entities\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class CreatePurchase
{
    public function __construct(private PurchaseService $service) {}

    public function handle(CreatePurchaseRequest $dto): Purchase
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.purchase.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => 'created',
            'entity_type' => 'purchase',
            'entity_id' => $create->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => 'created',
            'entity_type' => 'purchase',
            'entity_id' => $create->id,
            'chanels' => ['db']
        ]);
        DB::commit();
        return $create;
    }
}
