<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovementOutModel extends Model
{
    protected $table = 'stock_movements_out';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'qty_change',
        'stock_out_id',
        'created_by',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class);
    }

    public function stockOut()
    {
        return $this->belongsTo(StockOutModel::class, 'stock_outs_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
