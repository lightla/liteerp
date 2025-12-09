<?php

namespace Core\StockMovementIn\Infrastructure\Repositories;

use App\Models\StockMovementInModel;
use Core\StockMovementIn\Domain\Repositories\StockMovementInRepositoryInterface;
use Core\StockMovementIn\Domain\Entities\StockMovementIn;
use Illuminate\Support\Facades\DB;

class EloquentStockMovementInRepository implements StockMovementInRepositoryInterface
{
    public function create(StockMovementIn $entity): ?StockMovementIn
    {
        $create = StockMovementInModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function index(array $data): array
    {
        $rows = StockMovementInModel::select("stock_movements_in.*",
            "suppliers.unit_name as unit_name",
            "products.name as name",
            "products.unit as unit",
            "products.sku as sku",
            "category_product.name as category",
            "warehouses.name as warehouse")
        ->join("stock_ins","stock_ins.id"
            ,"=","stock_movements_in.stock_in_id")
        ->join("invoice_ins","invoice_ins.id"
            ,"=","stock_ins.invoice_in_id")
        ->join("products","products.id"
            ,"=","stock_movements_in.product_id")
        ->join("warehouses","warehouses.id"
            ,"=","stock_movements_in.warehouse_id")
        ->join("purchases","purchases.id"
            ,"=","invoice_ins.purchase_id")
        ->join("suppliers","suppliers.id"
            ,"=","purchases.supplier_id")
        ->join("category_product","category_product.id"
            ,"=","products.category_id")
        ->where('invoice_ins.business_id',$data['business_id'])
        ->where('stock_movements_in.stock_in_id',$data['stock_in_id']);
        return $rows->paginate($data['limit'] ?? 300)->toArray();
    }
    public function update(StockMovementIn $entity): ?StockMovementIn
    {
        StockMovementInModel::where('id',$entity->id)
        ->update($entity->toArray());
        return $entity;
    }
    public function findById(array $data): ?StockMovementIn
    {
        $row = StockMovementInModel::select("stock_movements_in.*")
        ->join("products","products.id","=","stock_movements_in.product_id")
        ->where('stock_movements_in.id',$data['id'])
        ->where('products.business_id',$data['business_id'])->first()?->toArray();
        if(!$row) {
            return $row;
        }
        return StockMovementIn::fromArray($data);
    }
    public function checkExists(array $data): ?StockMovementIn
    {
        $row = StockMovementInModel::select("stock_movements_in.*")
        ->join("products","products.id","=","stock_movements_in.product_id")
        ->where('stock_movements_in.stock_in_id',$data['stock_in_id'])
        ->where('stock_movements_in.product_id',$data['product_id'])
        ->where('stock_movements_in.warehouse_id',$data['warehouse_id'])
        ->where('products.business_id',$data['business_id'])->first()?->toArray();
        if(!$row) {
            return $row;
        }
        return StockMovementIn::fromArray($data);
    }
}