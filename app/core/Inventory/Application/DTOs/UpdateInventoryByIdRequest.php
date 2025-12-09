<?php

namespace Core\Inventory\Application\DTOs;

class UpdateInventoryByIdRequest
{
    public function __construct(
        public float $quantity = 0,
        public float $reserved_qty = 0,
        public int $created_by,
        public int $business_id,
        public int $id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            quantity: $data['quantity'] ?? 0,
            reserved_qty: $data['reserved_qty'] ?? 0,
            created_by: $data['user_id'],
            business_id: $data['business_id'],
            id: $data['id']
        );
    }

    public function toArray(): array
    {
        return [
            'quantity'     => $this->quantity,
            'reserved_qty' => $this->reserved_qty,
            'created_by'   => $this->created_by,
            'business_id'  => $this->business_id,
            'id'    => $this->id
        ];
    }
}
