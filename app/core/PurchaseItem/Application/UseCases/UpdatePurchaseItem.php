<?php

namespace Core\PurchaseItem\Application\UseCases;

use App\Exceptions\BadException;
use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Application\UseCases\CreateProduct;
use Core\PurchaseItem\Application\DTOs\CreatePurchaseItemRequest;
use Core\PurchaseItem\Domain\Services\PurchaseItemService;
use Core\Purchase\Application\UseCases\FindByIdPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdatePurchaseItem
{
    public function __construct(private PurchaseItemService $service, 
    private CreateProduct $createProduct,
    private FindByIdPurchase $findByIdPurchase) {}

    public function handle(CreatePurchaseItemRequest $dto)
    {
        DB::beginTransaction();
        // check purchase
        // $purchase = $this->findByIdPurchase->handle([
        //     'id' => $dto->purchase_id,
        //     'business_id' => $dto->business_id 
        // ]);
        // if(!$purchase->isDraft()) {
        //     throw new BadException(__("Currently you can not permission to change or add products"));
        // }
        // add product
        $item = $this->service->update($dto->toArray());
        Event::dispatch('erp.purchaseitem.update',[
            'user_id' => $dto->user_id,
            'business_id' => $dto->business_id,
            ...$item->toArray()
        ]);
        DB::commit();
        return $item;
    }
}