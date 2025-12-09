<?php

namespace Core\PurchaseItem\Application\UseCases;

use Core\PurchaseItem\Application\DTOs\CreatePurchaseItemRequest;
use Core\PurchaseItem\Domain\Services\PurchaseItemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreatePurchaseItem
{
    public function __construct(private PurchaseItemService $service) {}

    public function handle(CreatePurchaseItemRequest $dto)
    {
        DB::beginTransaction();
        // check purchase
        // add product
        $item = $this->service->create($dto->toArray());
        Event::dispatch('erp.purchaseitem.create',[
            'user_id' => $dto->user_id,
            'business_id' => $dto->business_id,
            ...$item->toArray()
        ]);
        DB::commit();
        return $item;
    }
}