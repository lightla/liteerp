<?php

namespace Core\StockMovementOut\Infrastructure\Repositories;

use App\Models\StockMovementOutModel;
use Core\StockMovementOut\Domain\Repositories\StockMovementOutRepositoryInterface;
use Core\StockMovementOut\Domain\Entities\StockMovementOut;
use Illuminate\Support\Facades\DB;

class EloquentStockMovementOutRepository implements StockMovementOutRepositoryInterface
{
    public function create(StockMovementOut $entity): StockMovementOut
    {
        // TODO: Add actual database logic
        $create = StockMovementOutModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function findById(array $data): ?StockMovementOut
    {
        $row = StockMovementOutModel::select("stock_movements_out.*")
            ->join("products", "products.id", "=", "stock_movements_out.product_id")
            ->join("warehouses", "warehouses.id", "=", "stock_movements_out.warehouse_id")
            ->where('stock_movements_out.id', $data['id'])
            ->where('products.business_id', $data['business_id'])
            ->first()?->toArray();
        if (!$row) {
            return null;
        }
        return StockMovementOut::fromArray($row);
    }
    public function findExists(array $data): ?StockMovementOut
    {
        $row = StockMovementOutModel::select("stock_movements_out.*")
            ->join("products", "products.id", "like", "stock_movements_out.product_id")
            ->join("warehouses", "warehouses.id", "like", "stock_movements_out.warehouse_id")
            ->where('stock_movements_out.product_id', $data['product_id'])
            ->where('products.business_id', $data['business_id'])
            ->where('stock_movements_out.warehouse_id', $data['warehouse_id'])
            ->where('stock_movements_out.stock_out_id', $data['stock_out_id'])
            ->first()?->toArray();
        if (!$row) {
            return null;
        }
        return StockMovementOut::fromArray($row);
    }
    public function update(StockMovementOut $entity): StockMovementOut
    {
        StockMovementOutModel::where('id', $entity->id)
            ->update($entity->toArray());
        return $entity;
    }
    public function index(array $data): array
    {
        return StockMovementOutModel::select(
            "stock_movements_out.*",
            "products.name as name",
            "products.sku as sku",
            DB::raw("ROUND(price_list.price,2) as price")
        )
            ->join("products", "products.id", "=", "stock_movements_out.product_id")
            ->join("warehouses", "warehouses.id", "=", "stock_movements_out.warehouse_id")
            ->join("stock_outs", "stock_outs.id", "=", "stock_movements_out.stock_out_id")
            ->join("invoice_outs", "invoice_outs.id", "=", "stock_outs.invoice_out_id")
            ->join("orders", "orders.id", "=", "invoice_outs.order_id")
            ->join("customers", "customers.id", "=", "orders.customer_id")
            ->join("customer_group", "customer_group.id", "=", "customers.group")
            ->join("price_list", function ($join) {
                $join->on("price_list.customer_group_id", "=", "customer_group.id")
                    ->on("price_list.product_id", "=", "products.id");
            })
            ->where('products.business_id', $data['business_id'])
            ->where('stock_movements_out.stock_out_id', $data['stock_out_id'])
            ->paginate(15)?->toArray();
    }
    public function indexWithLimit(array $data): array
    {
        return StockMovementOutModel::select(
            "stock_movements_out.stock_out_id",
            "stock_movements_out.product_id",
            "stock_movements_out.warehouse_id",
            DB::raw("SUM(qty_change) as total_quantity")
        )
            ->join("products", "products.id", "=", "stock_movements_out.product_id")
            ->where('products.business_id', $data['business_id'])
            ->groupBy(
                "stock_movements_out.stock_out_id",
                "stock_movements_out.product_id",
                "stock_movements_out.warehouse_id"
            )
            ->limit(500)
            ->get()
            ->toArray();
    }
}
