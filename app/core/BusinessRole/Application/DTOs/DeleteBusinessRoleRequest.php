<?php

namespace Core\BusinessRole\Application\DTOs;

class DeleteBusinessRoleRequest
{
    public function __construct(
        public int $business_id,
        public int $user_id,
        public int $role_user_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            business_id: $data['business_id'],
            user_id: $data['user_id'],
            role_user_id: $data['role_user_id']
        );
    }
    public function toArray(): array
    {
        return [
            'business_id' => $this->business_id,
            'user_id'   => $this->user_id,
            'role_user_id' => $this->role_user_id
        ];
    }
}