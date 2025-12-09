<?php

namespace Core\BusinessRole\Application\DTOs;

class CreateBusinessRoleRequest
{
    public function __construct(
        public int $user_id,
        public int $business_id,
        public ?string $role = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['id'],
            business_id: $data['business_id'],
            role: $data['role']
        );
    }
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'business_id' => $this->business_id,
            'role'  => $this->role
        ];
    }
}