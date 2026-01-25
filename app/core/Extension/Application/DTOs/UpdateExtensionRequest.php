<?php

namespace Core\Extension\Application\DTOs;

class UpdateExtensionRequest
{

    public function __construct(
        public int $user_id,
        public int $business_id,
        public bool $status,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            business_id: $data['business_id'],
            status: $data['status'],
            id: $data['id'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'business_id' => $this->business_id,
            'status'    => $this->status,
            'id'=> $this->id
        ];
    }
}