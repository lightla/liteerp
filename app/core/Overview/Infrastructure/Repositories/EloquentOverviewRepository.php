<?php

namespace Core\Overview\Infrastructure\Repositories;

use App\Models\CustomerModel;
use App\Models\CustomInvoiceInModel;
use App\Models\CustomInvoiceOutModel;
use App\Models\InventoryModel;
use App\Models\InvoiceInModel;
use App\Models\InvoiceOutModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\PurchaseModel;
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
    public function getPurchase(array $data): int
    {
        return PurchaseModel::whereMonth('created_at', $data['month'])
            ->whereYear('created_at', now()->year)
            ->where('business_id', $data['business_id'])
            ->count();
    }
    public function businessChart(array $data): array
    {
        return [
            'revenue' => OrderModel::select(DB::raw("
                    ROUND(
                        SUM(
                            (order_items.buy_quantity * order_items.price) 
                            + ((order_items.buy_quantity * order_items.price)  * order_items.tax / 100)
                            - ((order_items.buy_quantity * order_items.price)  * order_items.discount / 100)
                            + (
                                CASE 
                                    WHEN shippings.shipping_fee_actual > 0
                                        THEN shippings.shipping_fee_actual
                                    ELSE shippings.shipping_fee_estimated
                                END
                            )
                        )
                    ,2)
                    as total
                    "))
                ->join("order_items", "order_items.order_id", "=", "orders.id")
                ->join("invoice_outs", "invoice_outs.order_id", "=", "orders.id")
                ->join("stock_outs", "stock_outs.invoice_out_id", "=", "invoice_outs.id")
                ->join("shippings", "shippings.order_id", "=", "orders.id")
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
    public function getCacheForMonth(array $data): ?array
    {
        return (array) Cache::get('overview_createCacheForMonth_' . $data['business_id']) ?? null;
    }
    public function createCacheForMonth(array $data, int $business_id): array
    {
        Cache::put('overview_createCacheForMonth_' . $business_id, $data);
        return $data;
    }
    public function getCacheForYear(array $data): ?array
    {
        return (array) Cache::get('overview_getCacheForYear_' . $data['business_id']) ?? null;
    }
    public function createCacheForYear(array $data, int $business_id): array
    {
        Cache::put('overview_getCacheForYear_' . $business_id, $data);
        return $data;
    }
    public function getExpenseByTime(array $data): int
    {
        $expense = InvoiceInModel::select(DB::raw('SUM(total) as expense'))
            ->where('business_id', $data['business_id'])
            ->where('approved', true)
            ->whereBetween('created_at', [$data['start'], $data['end']])->first()?->expense;
        $expense ??= 0;
        $customExpense = CustomInvoiceInModel::select(DB::raw('SUM(amount) as expense'))
            ->where('business_id', $data['business_id'])
            ->where('approved', true)
            ->whereBetween('created_at', [$data['start'], $data['end']])->first()?->expense;;
        $customExpense ??= 0;
        return $expense + $customExpense;
    }
    public function getRevenueByTime(array $data): int
    {
        $revenue = OrderModel::select(DB::raw("
            ROUND(
                SUM(
                (order_items.buy_quantity * order_items.price) 
                + ((order_items.buy_quantity * order_items.price)  * order_items.tax / 100)
                - ((order_items.buy_quantity * order_items.price)  * order_items.discount / 100) 
                + (
                CASE 
                    WHEN shippings.shipping_fee_actual > 0
                        THEN shippings.shipping_fee_actual
                    ELSE shippings.shipping_fee_estimated
                END
               )
                )
            ,2)
            as revenue
            "))
            ->join("order_items", "order_items.order_id", "=", "orders.id")
            ->join("invoice_outs", "invoice_outs.order_id", "=", "orders.id")
            ->join("stock_outs", "stock_outs.invoice_out_id", "=", "invoice_outs.id")
            ->join("shippings", "shippings.order_id", "=", "orders.id")
            ->whereBetween('orders.created_at', [$data['start'], $data['end']])
            ->where('orders.deleted_at', NULL)
            ->where('stock_outs.status', 'completed')
            ->where('orders.business_id', $data['business_id'])
            ->first()?->revenue;
        $revenue ??= 0;
        $customRevenue = CustomInvoiceOutModel::select(DB::raw('SUM(amount) as revenue'))
            ->where('business_id', $data['business_id'])
            ->where('approved', true)
            ->whereBetween('created_at', [$data['start'], $data['end']])
            ->first()?->revenue;
        $customRevenue ??= 0;
        return $revenue + $customRevenue;
    }
    public function createCacheExpenseByTime(array $data, int $business_id): void
    {
        Cache::put('overview_getCacheExpenseByTime_' . $business_id, $data);
    }
    public function createCacheRevenueByTime(array $data, int $business_id): void
    {
        Cache::put('overview_getCacheRevenueByTime_' . $business_id, $data);
    }
    public function getCacheExpenseByTime(array $data): ?array
    {
        return (array) Cache::get('overview_getCacheExpenseByTime_' . $data['business_id']) ?? null;
    }
    public function getCacheRevenueByTime(array $data): ?array
    {
        return (array) Cache::get('overview_getCacheRevenueByTime_' . $data['business_id']) ?? null;
    }
}
