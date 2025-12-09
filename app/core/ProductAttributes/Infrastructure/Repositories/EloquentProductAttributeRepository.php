<?php

namespace Core\ProductAttributes\Infrastructure\Repositories;

use App\Models\ProductAttributeModel;
use Core\ProductAttributes\Domain\Repositories\ProductAttributeRepositoryInterface;
use Core\ProductAttributes\Domain\Entities\ProductAttribute;
use Illuminate\Support\Facades\Log;

class EloquentProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    public function create(ProductAttribute $entity): ProductAttribute
    {
        $dataInsert = [];
        foreach($entity->data as $key => $value ) {
            $dataInsert[$key] = [
                ...$value,
                'product_id' => $entity->product_id,
                'created_at' => now(),
                'updated_at' => now()  
            ];
        }
        ProductAttributeModel::insert($dataInsert);
        $entity->data = $dataInsert;
        return $entity;
    }
}