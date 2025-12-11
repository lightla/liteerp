<?php

namespace Core\StockIn\Application\DTOs;

class IndexStockInRequest
{
    public function __construct(
        public int $business_id,
        public int $created_by,
        public ?string $keywords,
        public ?string $status
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            business_id: (int) $data['business_id'],
            status : $data['status'],
            created_by: $data['user_id'],
            keywords: $data['keywords'] 
        );
    }

    public function toArray(): array
    {
        return [
            'business_id' => $this->business_id,
            'keywords' => $this->keywords,
            'status'      => $this->status,
            'created_by'  => $this->created_by
        ];
    }
}
