<?php

namespace Core\Supplier\Application\DTOs;

class IndexSupplierRequest {
    public function __construct(
        public ?string $keywords = null,
        public ?int $active = null,
        public int $business_id,
        public int $created_by,
        public ?string $order_by = null,
    )
    {
        
    }
    public static function fromArray(array $data): self{
        return new self(
            keywords: $data['keywords'] ?? null,
            active: $data['active'] ?? null,
            business_id: $data['business_id'],
            created_by: $data['user_id'],
            order_by: $data['order_by'] ?? 'DESC'  
        );
    }
    public function toArray(){
        return [
            'keywords' => $this->keywords,
            'active' => $this->active,
            'business_id'   => $this->business_id,
            'created_by'    => $this->created_by,
            'order_by'  => $this->order_by
        ];
    }
}