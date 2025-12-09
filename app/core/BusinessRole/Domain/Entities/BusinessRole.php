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
    public function setAdmin(){
        $this->role = 'admin';
    }
    public function setDefault(){
        $this->role ??= config('businessrole.default_role');
    }
}
