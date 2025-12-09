<?php

namespace Core\InventoryAdjustment\Application\DTOs;

class CreateInventoryAdjustmentRequest
{
    public function __construct(
        public int $product_id,
        public int $warehouse_id,
        public float $qty_adjusted,
        public ?string $reason,
        public int $adjusted_by,
        public ?int $id = null,
        public ?int $business_id,
        public ?int $created_by
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: $data['product_id'],
            warehouse_id: $data['warehouse_id'],
            qty_adjusted: (float) $data['qty_adjusted'],
            reason: $data['reason'] ?? null,
            adjusted_by: $data['user_id'],
            id: $data['id'] ?? null,
            business_id: $data['business_id'] ?? null,
            created_by: $data['user_id'] ?? null 
        );
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'product_id'    => $this->product_id,
            'warehouse_id'  => $this->warehouse_id,
            'qty_adjusted'  => $this->qty_adjusted,
            'reason'        => $this->reason,
            'adjusted_by'   => $this->adjusted_by,
            'business_id'   => $this->business_id,
            'created_by'    => $this->created_by
        ];
    }
}