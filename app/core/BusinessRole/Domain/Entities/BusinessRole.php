<?php

namespace Core\BusinessRole\Domain\Entities;

class BusinessRole
{
    public function __construct(
        public int $user_id,
        public int $business_id,
        public ?string $role = null,
        public ?int $id = null
    ) {}
    public function toArray()
    {
        return [
            'user_id' => $this->user_id,
            'business_id' => $this->business_id,
            'role' => $this->role ?? null,
            'id' => $this->id ?? null
        ];
    }
    public static function fromArray(array $data) : self
    {
        return new self(
            user_id: $data['user_id'],
            business_id: $data['business_id'],
            role: $data['role'],
            id: $data['id'] ?? null
        );
    }
    // set 
    public function setAdmin(){
        $this->role = 'admin';
    }
    public function setDefault(){
        $this->role ??= 'manager';
    }
    public function setManager(){
        $this->role = 'manager';
    }
    public function setSeller(){
        $this->role = 'seller';
    }
    public function setAccountanter(){
        $this->role = 'accountanter';
    }
    public function setWarehouseman(){
        $this->role = 'warehouseman';
    }
    public function setPurchaser(){
        $this->role = 'purchaser';
    }
    // check 
    public function isAdmin():bool{
        return $this->role === 'admin';
    }
    public function isManager():bool{
        return $this->role === 'manager';
    }
    public function isSeller():bool{
        return $this->role === 'seller';
    }
    public function isAccountanter():bool{
        return $this->role === 'accountanter';
    }
    public function isWarehouseman():bool{
        return $this->role === 'warehouseman';
    }
    public function isPurchaser():bool{
        return $this->role === 'purchaser';
    }
}
