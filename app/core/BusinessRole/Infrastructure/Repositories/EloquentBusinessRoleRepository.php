<?php

namespace Core\BusinessRole\Infrastructure\Repositories;

use App\Models\BusinessRoleModel;
use Core\BusinessRole\Domain\Repositories\BusinessRoleRepositoryInterface;
use Core\BusinessRole\Domain\Entities\BusinessRole;
use Illuminate\Support\Facades\Log;

class EloquentBusinessRoleRepository implements BusinessRoleRepositoryInterface
{
    public function create(BusinessRole $entity): BusinessRole
    {
        $create = BusinessRoleModel::create([
            'user_id' => $entity->user_id,
            'business_id' => $entity->business_id,
            'role' => $entity->role
        ]);
        $entity->id = $create['id'];
        return $entity;
    }
    public function update(BusinessRole $entity): BusinessRole
    {
        BusinessRoleModel::where('id',$entity->id)
        ->update($entity->toArray());
        return $entity;
    }
    public function findOne(array $data): ?BusinessRole
    {   
        
        /**
         * If it has not cache then implement database
         */
        $data = BusinessRoleModel::where('user_id',$data['user_id'])
            ->where('business_id',$data['business_id']);
        if($data->count() == false ) {
            return null;
        }
        $data = $data->first();
        return BusinessRole::fromArray($data->toArray());
    }
    public function listUserByRole(array $data) : array {
        return BusinessRoleModel::whereIn('role',$data['role'])
        ->where('business_id',$data['business_id'])
        ->where('id','!=',$data['created_by'])
        ->limit(config('businessrole.limit'))->get()?->toArray();
    }
}