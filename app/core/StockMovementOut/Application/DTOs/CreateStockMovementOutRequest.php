<?php

namespace Core\StockMovementOut\Application\DTOs;

class CreateStockMovementOutRequest
{
    public function __construct(
        public int $product_id,
        public int $warehouse_id,
        public float $qty_change,
        public int $stock_out_id,
        public int $created_by,
        public int $business_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: (int) $data['product_id'],
            warehouse_id: (int) $data['warehouse_id'],
            qty_change: (float) $data['qty_change'],
            stock_out_id: (int) $data['stock_out_id'],
            created_by: (int) $data['user_id'],
            business_id : (int) $data['business_id']
        );
    }

    public function toArray(): array
    {
        return [
            'product_id'  => $this->product_id,
            'warehouse_id'=> $this->warehouse_id,
            'qty_change'  => $this->qty_change,
            'stock_out_id'=> $this->stock_out_id,
            'created_by'  => $this->created_by,
            'business_id' => $this->business_id
        ];
    }
}
