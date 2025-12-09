<?php

namespace Core\StockMovementOut\Application\DTOs;

class ComletedStockMovementOutRequest
{
    public function __construct(
        public int $stock_out_id,
        public int $created_by,
        public int $business_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            stock_out_id: (int) $data['stock_out_id'],
            created_by: (int) $data['user_id'],
            business_id : (int) $data['business_id']
        );
    }

    public function toArray(): array
    {
        return [
            'stock_out_id'=> $this->stock_out_id,
            'created_by'  => $this->created_by,
            'business_id' => $this->business_id
        ];
    }
}
