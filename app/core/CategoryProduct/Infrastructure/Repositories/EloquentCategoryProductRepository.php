<?php

namespace Core\CategoryProduct\Infrastructure\Repositories;

use App\Exceptions\BadException;
use App\Models\CategoryProductModel;
use Core\CategoryProduct\Domain\Repositories\CategoryProductRepositoryInterface;
use Core\CategoryProduct\Domain\Entities\CategoryProduct;

class EloquentCategoryProductRepository implements CategoryProductRepositoryInterface
{
    public function create(CategoryProduct $entity): CategoryProduct
    {
        $create = CategoryProductModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function checkNameExists(array $data): bool
    {
        return CategoryProductModel::where('name',$data['name'])->where('business_id',$data['business_id'])->count() == false ? false : true;
    }
    public function index(array $data): array
    {
        $index = CategoryProductModel::with(['attributes'])->select("category_product.*","users.name as created_by_name")
        ->join("users","users.id","=","category_product.created_by")
        ->where('category_product.business_id',$data['business_id']);
        if(!empty($data['keywords'])) {
            $index = $index->where('category_product.name','like','%' . $data['keywords'] . '%');
        }
        return $index->paginate(15)->toArray();
    }
    public function findById(array $data): ?CategoryProduct
    {
        $exists = CategoryProductModel::where('id',$data['id'])
        ->where('business_id',$data['business_id']);
        if($exists->count() == false ) {
            return null;
        }
        $exists = $exists->first();
        return CategoryProduct::fromArray($exists->toArray());
    }
    public function getByName(array $data): CategoryProduct
    {
        $row = CategoryProductModel::where('name',$data['name'])->where('business_id',$data['business_id'])->first();
        $entity = CategoryProduct::fromArray($row->toArray());
        return $entity;
    }
    public function update(CategoryProduct $entity) : CategoryProduct {
        CategoryProductModel::where('id',$entity->id)
        ->where('business_id',$entity->business_id)
        ->update($entity->toArray());
        return $entity;
    }
    public function delete(CategoryProduct $entity) : CategoryProduct {
        CategoryProductModel::where('id',$entity->id)
        ->where('business_id',$entity->business_id)
        ->delete();
        return $entity;
    }
}