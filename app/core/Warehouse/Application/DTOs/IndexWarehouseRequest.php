<?php

namespace Core\Warehouse\Application\DTOs;

class IndexWarehouseRequest
{
    public function __construct(
        public ?string $keywords = null,
        public ?int $active = null,
        public ?int $limit = null,
        public int $created_by,
        public int $business_id 
    ) {}
    public static function fromArray(array $data) : self {
        return new self(
            keywords: $data['keywords'] ?? null,
            active: $data['active'] ?? null,
            limit: $data['limit'] ?? null,
            created_by: $data['user_id'],
            business_id: $data['business_id']
        );
    }
    public function toArray(): array {
        return [
            'keywords' => $this->keywords,
            'active' => $this->active,
            'limit'  => $this->limit,
            'created_by' => $this->created_by,
            'business_id'   => $this->business_id
        ];
    }
}
