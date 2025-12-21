<?php

namespace Core\ProductAttributes\Infrastructure\Repositories;

use App\Models\ProductAttributeModel;
use Core\ProductAttributes\Domain\Repositories\ProductAttributeRepositoryInterface;

class EloquentProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    public function create(array $data): array
    {
        ProductAttributeModel::insert($data);
        return $data;
    }
    public function deleteByCategory(int $category_id): bool
    {
       return ProductAttributeModel::where('category_id',$category_id)->delete() ?? false;
    
    }
}