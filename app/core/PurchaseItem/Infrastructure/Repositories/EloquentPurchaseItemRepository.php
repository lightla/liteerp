<?php

namespace Core\PurchaseItem\Infrastructure\Repositories;

use App\Models\PurchaseItemModel;
use Core\PurchaseItem\Domain\Repositories\PurchaseItemRepositoryInterface;
use Core\PurchaseItem\Domain\Entities\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EloquentPurchaseItemRepository implements PurchaseItemRepositoryInterface
{
    public function create(PurchaseItem $entity): PurchaseItem
    {
        //Log::info(json_encode($entity->toArray()));
        $create = PurchaseItemModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function index(array $data): array
    {
        return PurchaseItemModel::select("purchase_items.*",
        "products.image as image","products.name as name",
        "products.sku as sku","products.unit as unit",
        "category_product.name as category_name",
        "suppliers.unit_name as unit_name",
        "products.id as product_id",
        DB::raw("(purchase_items.buy_quantity 
            + purchase_items.gift_quantity
            + purchase_items.compensation_quantity
            + purchase_items.conversion_quantity) as quantity"),
        DB::raw("(purchase_items.buy_quantity * purchase_items.unit_cost) as subtotal"),
        DB::raw("ROUND(((purchase_items.buy_quantity * unit_cost) * purchase_items.tax / 100),2) as total_tax"),
        DB::raw("ROUND(
            ((purchase_items.buy_quantity * unit_cost) + ((purchase_items.buy_quantity * unit_cost) * purchase_items.tax / 100))
            ,2) 
            as total"))
        ->join("products","products.id","=","purchase_items.product_id")
        ->join("category_product","category_product.id","=","products.category_id")
        ->join("purchases","purchases.id","=","purchase_items.purchase_id")
        ->join("suppliers","suppliers.id","=","purchases.supplier_id")
        ->where('purchase_items.purchase_id', $data['purchase_id'])
        ->where('purchases.business_id', $data['business_id'])
        ->paginate(15)->toArray();
    }
    public function findByPurchaseIdAndProductId(array $data): ?PurchaseItem
    {
        $row = PurchaseItemModel::select("purchase_items.*")
        ->join("purchases","purchases.id","=","purchase_items.purchase_id")
        ->where('purchase_items.purchase_id',$data['purchase_id'])
        ->where('purchase_items.product_id',$data['product_id'])->first()?->toArray();
        if(!$row) {
            return $row;
        }
        return PurchaseItem::fromArray($row);
    }
    public function findById(array $data): PurchaseItem
    {
        $row = PurchaseItemModel::select("purchase_items.*")
        ->join("purchases","purchases.id","=","purchase_items.purchase_id")
        ->where('purchases.business_id',$data['business_id'])
        ->where('purchase_items.id',$data['id'])
        ->first()?->toArray();
        if(!$row) {
            return $row;
        }
        return PurchaseItem::fromArray($row);
    }
    public function update(PurchaseItem $entity): PurchaseItem
    {
        PurchaseItemModel::where('id',$entity->id)
        ->update($entity->toArray());
        return $entity;
    }
    public function indexMinimal(array $data): array
    {
        return PurchaseItemModel::select("purchase_items.*")
        ->join("purchases","purchases.id","=","purchase_items.purchase_id")
        ->where('purchase_items.purchase_id', $data['purchase_id'])
        ->where('purchases.business_id', $data['business_id'])
        ->limit(300)
        ->get()->toArray();
    }
}
