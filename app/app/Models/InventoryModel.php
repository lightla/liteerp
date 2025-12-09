<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    protected $table = 'inventories';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'reserved_qty',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id');
    }

    public function getAvailableAttribute()
    {
        return $this->quantity - $this->reserved_qty;
    }
}
