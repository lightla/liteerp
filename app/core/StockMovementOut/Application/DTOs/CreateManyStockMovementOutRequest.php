<?php

namespace Core\StockMovementOut\Application\DTOs;

class CreateManyStockMovementOutRequest
{
    public function __construct(
        public array $list,
        public int $created_by,
        public int $business_id,
        public int $stock_out_id,
        public int $order_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            list: $data['list'],
            created_by: $data['user_id'],
            business_id : $data['business_id'],
            stock_out_id: $data['stock_out_id'],
            order_id: $data['order_id']
        );
    }

    public function toArray(): array
    {
        return [
            'list'  => $this->list,
            'created_by'  => $this->created_by,
            'business_id' => $this->business_id,
            'stock_out_id'  => $this->stock_out_id,
            'order_id'  => $this->order_id
        ];
    }
}
