<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProductModel extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     */
    protected $table = 'category_product';

    /**
     * Các cột được phép gán hàng loạt (mass assignable).
     */
    protected $fillable = [
        'name',
        'slug',
        'deleted_at',
        'business_id',
        'description',
        'created_by',
        'tax'
    ];

    /**
     * Lấy các sản phẩm thuộc danh mục (nếu có quan hệ Product).
     */
    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_id', 'id');
    }
}
