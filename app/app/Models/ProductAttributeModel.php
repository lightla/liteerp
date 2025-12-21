<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttributeModel extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';

    protected $fillable = [
        'category_id',
        'key',
        'type',
        'value',
    ];

    protected $casts = [
        'category_id' => 'integer'
    ];
}
