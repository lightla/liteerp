<?php

namespace Core\OrderItem\Application\DTOs;

class DeleteOrderItemRequest
{
    public function __construct(
        public int $business_id,
        public int $user_id,
        public int $id 
    ) {}

    /**
     * Create DTO from array input
     */
    public static function fromArray(array $data): self
    {
        return new self(
            business_id: $data['business_id'],
            user_id: $data['user_id'],
            id: $data['id'] 
        );
    }

    /**
     * Convert DTO to array (Repository or Entity)
     */
    public function toArray(): array
    {
        return [
            'business_id' => $this->business_id,
            'user_id' => $this->user_id,
            'id'      => $this->id
        ];
    }
}
