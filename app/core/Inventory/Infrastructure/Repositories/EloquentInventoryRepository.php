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
            "warehouses.name as warehouse",
            "category_product.name as category",
            "category_product.tax as tax"
        )
            ->join("products", "products.id", "=", "inventories.product_id")
            ->join("warehouses", "warehouses.id", "=", "inventories.warehouse_id")
            ->join(
                "category_product",
                "category_product.id",
                "=",
                "products.category_id"
            );
        $index = $index->groupBy(
            "inventories.id"
        );
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
    public function indexForOrder(array $data): array
    {
        $index = InventoryModel::select(
            "inventories.*",
            "products.name as name",
            "products.sku as sku",
            "products.unit as unit",
            "warehouses.name as warehouse",
            "category_product.name as category",
            "category_product.tax as tax",
            "price_list.price as price"
        )
            ->join("products", "products.id", "=", "inventories.product_id")
            ->join("order_items", "order_items.inventory_id", "=", "inventories.id")
            ->join("orders", "orders.id", "=", "order_items.order_id")
            ->join("customers", "customers.id", "=", "orders.customer_id")
            ->join("customer_group", "customer_group.id", "=", "customers.group")
            ->join("warehouses", "warehouses.id", "=", "inventories.warehouse_id")
            ->join("category_product","category_product.id","=","products.category_id")
            ->join("price_list",function($join) {
                $join->on("price_list.product_id","=","products.id")
                     ->on("price_list.customer_group_id","=","customer_group.id");
            });
        $index = $index->where('customer_group.id',$data['customer_group_id']);
        $index = $index->groupBy(
            "inventories.id",
            "erpsoft.price_list.price"
        );
        $index = $index->paginate(15)->toArray();
        return $index;
    }
}
