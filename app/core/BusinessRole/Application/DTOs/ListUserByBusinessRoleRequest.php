<?php

namespace Core\BusinessRole\Application\DTOs;

class ListUserByBusinessRoleRequest
{
    public function __construct(
        public array $role,
        public int $business_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            role: $data['role'],
            business_id: $data['business_id']
        );
    }
    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'business_id' => $this->business_id
        ];
    }
}