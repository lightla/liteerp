<?php

namespace Core\Business\Infrastructure\Repositories;

use App\Models\BusinessModel;
use Core\Business\Domain\Repositories\BusinessRepositoryInterface;
use Core\Business\Domain\Entities\Business;

class EloquentBusinessRepository implements BusinessRepositoryInterface
{
    public function create(Business $entity): Business
    {
        $business = BusinessModel::create($entity->toArray());
        $entity->id = $business['id'];
        return $entity;
    }
    public function index(int $user_id): array
    {
        $list = BusinessModel::select("business.*","business_role.role as role")
        ->join("business_role","business_role.business_id","=","business.id")
        ->where('business_role.user_id',$user_id)
        ->limit(50)->get()->toArray();
        return $list;
    }
    public function checkExists(Business $entity): bool
    {
        $row = BusinessModel::select("business.*")
        ->where('business.name',$entity->name)
        ->where('business.address',$entity->address);
        return $row->count() ?? true;
    }
    public function findByIdWithFullData(array $data) : ?array
    {
       return BusinessModel::select("business.*",
            "business_role.role as role",
            "business_role.user_id as user_id")
       ->join("business_role","business_role.business_id","=","business.id")
        ->where('business.id',$data['business_id'])
        ->where('business_role.user_id',$data['user_id'])->first()?->toArray();
    }
    public function findById(array $data) : ?Business
    {
       $row = BusinessModel::select("business.*")
        ->where('business.id',$data['id'])
        ->where('business_role.user_id',$data['user_id'])->first()?->toArray();
        if(!$row) {
            return null;
        }
        return Business::fromArray($row);
    }
    public function findByName(array $data) : ?Business
    {
       $row = BusinessModel::select("business.*")
        ->where('business.name',$data['name'])
        ->first()?->toArray();
        if(!$row) {
            return null;
        }
        return Business::fromArray($row);
    }
    public function update(Business $entity): Business
    {
        BusinessModel::where('business.id',$entity->id)
        ->update($entity->toArray());
        return $entity;
    }
    public function all() : array {
        return BusinessModel::get()->toArray();
    }
}