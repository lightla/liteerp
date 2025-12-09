<?php

namespace Core\BusinessRole\Application\DTOs;

class CheckRoleBusinessRoleRequest
{
    public function __construct(
        public int $user_id,
        public int $business_id,
        public string $action 
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            business_id: $data['business_id'],
            action: $data['action']
        );
    }
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'business_id' => $this->business_id,
            'action'  => $this->action
        ];
    }
}