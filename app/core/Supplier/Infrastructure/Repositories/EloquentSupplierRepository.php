<?php

namespace Core\Supplier\Infrastructure\Repositories;

use App\Models\SupplierModel;
use Core\Supplier\Domain\Repositories\SupplierRepositoryInterface;
use Core\Supplier\Domain\Entities\Supplier;

class EloquentSupplierRepository implements SupplierRepositoryInterface
{
    public function create(Supplier $entity): Supplier
    {
        $create = SupplierModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function index(array $data): array {
        $list = SupplierModel::where('business_id',$data['business_id'])
        ->where('unit_name','like','%'.($data['keywords'] ?? '').'%');
        if(isset($data['active'])) {
            $list = $list->where('active',$data['active']);
        }
        return $list->paginate(15)->toArray();
    }
    public function findById(array $data): ?Supplier
    {
        $row = SupplierModel::where('id',$data['id'])
        ->where('business_id',$data['business_id'])->first()?->toArray();
        if(!$row) {
            return null;
        }
        return Supplier::fromArray($row);
    }
    public function findByName(array $data): ?Supplier
    {
        $row = SupplierModel::where('unit_name',$data['unit_name'])
        ->where('business_id',$data['business_id'])->first()?->toArray();
        if(!$row) {
            return null;
        }
        return Supplier::fromArray($row);
    }
    public function update(Supplier $entity): Supplier
    {
        SupplierModel::where('id',$entity->id)
        ->where('business_id',$entity->business_id)->update($entity->toArray());
        return $entity;
    }
}
