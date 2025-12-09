<?php

namespace Core\Product\Infrastructure\Repositories;

use App\Models\ProductModel;
use Core\Product\Domain\Repositories\ProductRepositoryInterface;
use Core\Product\Domain\Entities\Product;
use Illuminate\Support\Facades\Log;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function create(Product $entity): Product
    {
        $create = ProductModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function checkExists(Product $entity): bool
    {
        $update = ProductModel::where('sku', $entity->sku);
        if ($entity->id) {
            $update = $update->where('id', '!=', $entity->id);
        }
        return $update->count() == false ? false : true;
    }
    public function findOneWithFullData(array $data): ?array
    {
        return ProductModel::with(['category', 'attributes'])->where('id', $data['id'])
            ->where('business_id', $data['business_id'])->first()?->toArray();
    }
    public function findById(array $data): ?Product
    {
        $row = ProductModel::where('id', $data['id'])
            ->where('business_id', $data['business_id']);
        if ($row->count() == false) {
            return null;
        }
        $row = $row->first();
        $entity = Product::fromArray($row->toArray());
        $entity->id = $row->id;
        return $entity;
    }
    public function index(array $data): array
    {
        $rows = ProductModel::select("products.*")
            ->with(['category'])
            ->where(function ($query) use ($data) {
                return $query->where('products.business_id', $data['business_id'])
                    ->where('products.name', 'like', '%' . ($data['keywords'] ?? '') . '%');
            })
            ->orWhere(function($query)  use ($data) {
                return $query->where('products.business_id', $data['business_id'])
                    ->where('products.sku', 'like', '%' . ($data['keywords'] ?? '') . '%');
            });
        return $rows->paginate(15)->toArray();
    }
    public function update(Product $entity): Product
    {
        // TODO: Add actual database logic
        ProductModel::where('id', $entity->id)
        ->where('products.business_id', $entity->business_id)->update($entity->toArray());
        return $entity;
    }
}
