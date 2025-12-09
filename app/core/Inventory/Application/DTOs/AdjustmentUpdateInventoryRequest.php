<?php

namespace Core\Inventory\Application\DTOs;

class AdjustmentUpdateInventoryRequest
{
    public function __construct(
        public int $product_id,
        public int $warehouse_id,
        public float $quantity = 0,
        public float $reserved_qty = 0,
        public int $created_by,
        public int $business_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: $data['product_id'],
            warehouse_id: $data['warehouse_id'],
            quantity: $data['quantity'] ?? 0,
            reserved_qty: $data['reserved_qty'] ?? 0,
            created_by: $data['user_id'],
            business_id: $data['business_id']
        );
    }

    public function toArray(): array
    {
        return [
            'product_id'   => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'quantity'     => $this->quantity,
            'reserved_qty' => $this->reserved_qty,
            'created_by'   => $this->created_by,
            'business_id'  => $this->business_id
        ];
    }
}
