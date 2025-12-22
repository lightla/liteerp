<?php

namespace Core\StockOut\Application\DTOs;

class IndexStockOutRequest
{
    public function __construct(
        public int $business_id,
        public ?string $status = null,
        public int $created_by,
        public ?string $keywords,
        public ?string $order_by = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            business_id: $data['business_id'],
            keywords: $data['keywords'],
            created_by: $data['user_id'],
            status: $data['status'] ?? null,
            order_by: $data['order_by'] ?? 'DESC'
        );
    }

    public function toArray(): array
    {
        return [
            'business_id'    => $this->business_id,
            'status'         => $this->status,
            'created_by'     => $this->created_by,
            'keywords'  => $this->keywords,
            'order_by'  => $this->order_by
        ];
    }
}
