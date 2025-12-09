<?php

namespace Core\Inventory\Infrastructure\Repositories;

use App\Models\InventoryModel;
use App\Models\StockMovementIn;
use Core\Inventory\Domain\Repositories\InventoryRepositoryInterface;
use Core\Inventory\Domain\Entities\Inventory;
use Illuminate\Support\Facades\DB;

class EloquentInventoryRepository implements InventoryRepositoryInterface
{
    public function create(Inventory $entity): Inventory
    {
        $create = InventoryModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function findByOneByProductAndWarehouse(array $data): ?Inventory
    {
        $row = InventoryModel::where('product_id', $data['product_id'])
            ->where('warehouse_id', $data['warehouse_id'])->first()?->toArray();
        if (!$row) {
            return $row;
        }
        return Inventory::fromArray($row);
    }
    public function findById(array $data): ?Inventory
    {
        $row = InventoryModel::select("inventories.*")
            ->join("products", "products.id", "=", "inventories.product_id")
            ->where('inventories.id', $data['id'])
            ->where('products.business_id', $data['business_id'])
            ->first()?->toArray();
        if (!$row) {
            return $row;
        }
        return Inventory::fromArray($row);
    }
    public function update(Inventory $entity): Inventory
    {
        InventoryModel::where('id', $entity->id)
            ->update($entity->toArray());
        return $entity;
    }
    public function index(array $data): array
    {
        $index = InventoryModel::select(
            "inventories.*",
            "products.name as name",
            "products.sku as sku",
            "products.unit as unit",
            "price_list.price",
            "warehouses.name as warehouse",
            "category_product.name as category",
            "category_product.tax as tax",
            "suppliers.unit_name as unit_name",
            "purchases.id as purchase_id"
        )
            ->join("products", "products.id", "=", "inventories.product_id")
            ->join("warehouses", "warehouses.id", "=", "inventories.warehouse_id")
            ->join(
                "category_product",
                "category_product.id",
                "=",
                "products.category_id"
            )
            ->joinSub(
                DB::table('purchase_items')
                    ->selectRaw('product_id, MAX(id) AS max_id')
                    ->groupBy('product_id'),
                'pi',
                fn($join) => $join->on('pi.product_id', '=', 'products.id')
            )
            ->join('purchase_items', 'purchase_items.id', '=', 'pi.max_id')

            ->join(
                "purchases",
                "purchases.id",
                "=",
                "purchase_items.purchase_id"
            )
            ->join(
                "suppliers",
                "suppliers.id",
                "=",
                "purchases.supplier_id"
            )
            ->join(
                "invoice_ins",
                "invoice_ins.purchase_id",
                "=",
                "purchases.id"
            )
            ->join(
                "stock_ins",
                "stock_ins.invoice_in_id",
                "=",
                "invoice_ins.id"
            )->join(
                "price_list",
                "price_list.product_id",
                "=",
                "products.id"
            );
            $index = $index->groupBy(
                "inventories.id",
                "suppliers.unit_name",
                "purchases.id",
                "purchase_items.id",
                "purchase_items.product_id",
                "purchase_items.purchase_id",
                "price_list.price"
            );
        if (!empty($data['purchase_id'])) {
            $index = $index->where('purchases.id', $data['purchase_id']);
        }
        if (!empty($data['keywords'])) {
            $index = $index->where(
                'products.name',
                'like',
                '%' . $data['keywords'] . '%'
            );
        }
        $index = $index->paginate(15)->toArray();
        return $index;
    }
}
