<?php

namespace Core\Inventory\Application\DTOs;

class GetInventoryByProductWarehouseRequest
{
    public function __construct(
        public int $product_id,
        public int $warehouse_id,
        public int $business_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: $data['product_id'],
            warehouse_id: $data['warehouse_id'],
            business_id: $data['business_id']
        );
    }

    public function toArray(): array
    {
        return [
            'product_id'   => $this->product_id,
            'warehouse_id'   => $this->warehouse_id,
            'business_id'  => $this->business_id
        ];
    }
}
