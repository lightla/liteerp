<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovementInModel extends Model
{
    protected $table = 'stock_movements_in';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'qty_change',
        'stock_in_id',
        'created_by',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id');
    }
    public function stockIn()
    {
        return $this->belongsTo(StockInModel::class, 'stock_ins_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
