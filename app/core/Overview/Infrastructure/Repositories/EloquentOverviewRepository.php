<?php

namespace Core\Overview\Infrastructure\Repositories;

use App\Models\CustomerModel;
use App\Models\InventoryModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use Core\Overview\Domain\Repositories\OverviewRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EloquentOverviewRepository implements OverviewRepositoryInterface
{
    public function getCustomer(array $data): int
    {
        return CustomerModel::whereMonth('created_at', $data['month'])
            ->whereYear('created_at', now()->year)
            ->where('business_id', $data['business_id'])
            ->count();
    }
    public function getOrder(array $data): int
    {
        return OrderModel::whereMonth('created_at', $data['month'])
            ->whereYear('created_at', now()->year)
            ->where('business_id', $data['business_id'])
            ->count();
    }
    public function getProduct(array $data): int
    {
        return ProductModel::whereMonth('created_at', $data['month'])
            ->whereYear('created_at', now()->year)
            ->where('business_id', $data['business_id'])
            ->count();
    }
    public function getRevenue(array $data): int
    {
        return OrderModel::select(DB::raw("
            SUM((order_items.buy_quantity * order_items.price) 
            + ((order_items.buy_quantity * order_items.price)  
                * order_items.tax / 100)
            - ((order_items.buy_quantity * order_items.price)  
                * order_items.discount / 100)) as total
            "))
            ->join("order_items", "order_items.order_id", "=", "orders.id")
            ->join("invoice_outs", "invoice_outs.order_id", "=", "orders.id")
            ->join("stock_outs", "stock_outs.invoice_out_id", "=", "invoice_outs.id")
            ->whereMonth('orders.created_at', $data['month'])
            ->whereYear('orders.created_at', now()->year)
            ->where('orders.deleted_at', NULL)
            ->where('stock_outs.status', 'completed')
            ->where('orders.business_id', $data['business_id'])
            ->first()?->total ?? 0;
    }
    public function businessChart(array $data): array
    {
        return [
            'revenue' => OrderModel::select(DB::raw("
                    ROUND(SUM((order_items.buy_quantity * order_items.price) 
                    + ((order_items.buy_quantity * order_items.price)  
                        * order_items.tax / 100)
                    - ((order_items.buy_quantity * order_items.price)  
                        * order_items.discount / 100)),2) as total
                    "))
                ->join("order_items", "order_items.order_id", "=", "orders.id")
                ->join("invoice_outs", "invoice_outs.order_id", "=", "orders.id")
                ->join("stock_outs", "stock_outs.invoice_out_id", "=", "invoice_outs.id")
                ->whereMonth('orders.created_at', $data['month'])
                ->whereYear('orders.created_at', now()->year)
                ->where('orders.deleted_at', NULL)
                ->where('stock_outs.status', 'completed')
                ->where('orders.business_id', $data['business_id'])
                ->first()?->total ?? 0,
            'customer' => CustomerModel::whereMonth('created_at', $data['month'])
                ->whereYear('created_at', now()->year)
                ->where('business_id', $data['business_id'])->count(),
            'product'  => ProductModel::whereMonth('created_at', $data['month'])
                ->whereYear('created_at', now()->year)
                ->count(),
            'order'  => OrderModel::whereMonth('created_at', $data['month'])
                ->whereYear('created_at', now()->year)
                ->count(),
            'suppliers'  => SupplierModel::whereMonth('created_at', $data['month'])
                ->whereYear('created_at', now()->year)
                ->count(),
            'inventory'  => InventoryModel::select(DB::raw("SUM(quantity - reserved_qty) as total"))
                ->whereMonth('created_at', $data['month'])
                ->whereYear('created_at', now()->year)
                ->first()?->total ?? 0
        ];
    }
    public function getCacheForMonth(): ?array
    {
        return (array) Cache::get('overview_createCacheForMonth') ?? null;
    }
    public function createCacheForMonth(array $data): array
    {
        Cache::put('overview_createCacheForMonth', $data);
        return $data;
    }
    public function getCacheForYear(): ?array
    {
        return (array) Cache::get('overview_getCacheForYear') ?? null;
    }
    public function createCacheForYear(array $data): array
    {
        Cache::put('overview_getCacheForYear', $data);
        return $data;
    }
}
