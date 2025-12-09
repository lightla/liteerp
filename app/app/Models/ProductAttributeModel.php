<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttributeModel extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     */
    protected $table = 'product_attributes';

    /**
     * Các cột được phép gán hàng loạt.
     */
    protected $fillable = [
        'product_id',
        'key',
        'value',
    ];

    /**
     * Kiểu dữ liệu cast (nếu có).
     */
    protected $casts = [
        'product_id' => 'integer',
    ];

    /**
     * Quan hệ: Thuộc về sản phẩm nào.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    /**
     * Scope: Tìm thuộc tính theo key cụ thể.
     */
    public function scopeKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    /**
     * Scope: Tìm thuộc tính theo product_id.
     */
    public function scopeForProduct($query, int $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Lấy danh sách attributes theo dạng key => value.
     * (Dễ dùng trong Controller hoặc API)
     */
    public static function listForProduct(int $productId): array
    {
        return static::forProduct($productId)
            ->pluck('value', 'key')
            ->toArray();
    }
}
