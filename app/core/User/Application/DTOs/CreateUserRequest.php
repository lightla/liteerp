<?php

namespace Core\User\Application\DTOs;

class CreateUserRequest
{
    public function __construct(
        public string $email,
        public ?int $created_by = null,
        public ?int $business_id = null,
        public string $role,
        public ?int $id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            created_by: $data['user_id'] ?? null,
            business_id: $data['business_id'] ?? null,
            role: $data['role'] ?? null,
            id: $data['id'] ?? null 
        );
    }
    public function toArray()
    {
        return [
            'email' => $this->email,
            'created_by' => $this->created_by,
            'business_id'   => $this->business_id,
            'role'  => $this->role,
            'id'    => $this->id
        ];
    }
}
