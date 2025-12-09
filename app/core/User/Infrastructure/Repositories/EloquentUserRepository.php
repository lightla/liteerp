<?php

namespace Core\User\Infrastructure\Repositories;

use App\Models\User as ModelsUser;
use Core\User\Domain\Repositories\UserRepositoryInterface;
use Core\User\Domain\Entities\User;
use Illuminate\Support\Facades\Cache;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function index(array $data): array
    {
        $rows = ModelsUser::select("users.*","business_role.role as role")
        ->join("business_role","business_role.user_id","=","users.id")
        ->where("business_role.business_id",$data['business_id']);
        if(!empty($data['keywords'])) {
            $rows = $rows->where('users.name','like','%'. $data['keywords'] .'%');
        }
        $rows = $rows->paginate(15)->toArray();
        return $rows;
    }
    public function findById(array $data): ?User
    {
        $row = ModelsUser::select("users.*","business_role.role as role")
        ->join("business_role","business_role.user_id","=","users.id")
        ->where("business_role.business_id",$data['business_id'])
        ->where('users.id',$data['id'])
        ->first()?->toArray();
        if(!$row) {
            return null;
        }
        return User::fromArray($row);
    }
    public function findByEmailOnSystem(array $data): ?User{
        $row = ModelsUser::where('users.email',$data['email'])
        ->first()?->toArray();
        if(!$row) {
            return null;
        }
        return User::fromArray($row);
    }
    public function findByEmail(array $data): ?User
    {
        $row = ModelsUser::select("users.*","business_role.role as role")
        ->join("business_role","business_role.user_id","=","users.id")
        ->where("business_role.business_id",$data['business_id'])
        ->where('users.email',$data['email'])
        ->first()?->toArray();
        if(!$row) {
            return null;
        }
        return User::fromArray($row);
    }
}