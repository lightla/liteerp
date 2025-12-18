<?php

namespace Core\PurchaseItem\Application\UseCases;

use Core\PurchaseItem\Application\DTOs\DeletePurchaseItemRequest;
use Core\PurchaseItem\Domain\Services\PurchaseItemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeletePurchaseItem
{
    public function __construct(private PurchaseItemService $service) {}

    public function handle(DeletePurchaseItemRequest $dto)
    {
        DB::beginTransaction();
        // add product
        $item = $this->service->delete($dto->toArray());
        Event::dispatch('erp.purchaseitem.delete',[
            'user_id' => $dto->user_id,
            'business_id' => $dto->business_id,
            ...$item->toArray()
        ]);
        DB::commit();
        return $item;
    }
}