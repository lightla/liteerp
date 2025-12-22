<?php

namespace Core\Customer\Infrastructure\Repositories;

use App\Models\CustomerModel;
use Core\Customer\Domain\Repositories\CustomerRepositoryInterface;
use Core\Customer\Domain\Entities\Customer;
use Illuminate\Support\Facades\DB;

class EloquentCustomerRepository implements CustomerRepositoryInterface
{
    public function findById(array $data): ?Customer
    {
        $row = CustomerModel::where('id',$data['id'])
        ->where('business_id',$data['business_id'])->first()?->toArray();
        if(!$row) {
            return null;
        }
        $entity = Customer::fromArray($row);
        return $entity;
    }
    public function findByPhone(array $data): ?Customer
    {
        $row = CustomerModel::where('business_id',$data['business_id'])
        ->where('phone',$data['phone'])
        ->first()?->toArray();
        if(!$row) {
            return null;
        }
        $entity = Customer::fromArray($row);
        return $entity;
    }
    public function create(Customer $entity): Customer
    {
        // TODO: Add actual database logic
        $create = CustomerModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function all(array $data): array {
        $list = CustomerModel::select("customers.*","customer_group.name as group_name",
        DB::raw("count(orders.id) as total_order" ))
        ->join("customer_group","customer_group.id","=","customers.group")
        ->leftJoin("orders","orders.customer_id","=","customers.id")
        ->where('customers.business_id',$data['business_id'])
        ->groupBy("customers.id")
        ->orderBy("customers.id",$data['order_by']);
        if(!empty($data['type'])) {
            $list = $list->where('customers.type',$data['type']);
        }
        if(!empty($data['keywords'])) {
            $list = $list->where('customers.name','like','%'.$data['keywords'].'%');
        }
        return $list->paginate(15)->toArray();
    }
    public function update(Customer $entity) : Customer {
        CustomerModel::where('id',$entity->id)
        ->where('business_id',$entity->business_id)
        ->update($entity->toArray());
        return $entity;
    }
    public function delete(Customer $entity): Customer
    {
        CustomerModel::where('id',$entity->id)
        ->delete();
        return $entity;
    }
}