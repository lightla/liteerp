<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingProviderModel extends Model
{
    use SoftDeletes;

    protected $table = 'shipping_providers';

    /**
     * Các cột được phép gán
     */
    protected $fillable = [
        'name',
        'code',
        'logo',
        'active',
        'business_id'
    ];

    /**
     * Ép kiểu dữ liệu
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Scope: Chỉ lấy đơn vị đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
