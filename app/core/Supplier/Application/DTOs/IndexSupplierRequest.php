<?php

namespace Core\Supplier\Application\DTOs;

class IndexSupplierRequest {
    public function __construct(
        private ?string $keywords = null,
        private ?int $active = null,
        private int $business_id
    )
    {
        
    }
    public static function fromArray(array $data): self{
        return new self(
            keywords: $data['keywords'] ?? null,
            active: $data['active'] ?? null,
            business_id: $data['business_id'] ?? null  
        );
    }
    public function toArray(){
        return [
            'keywords' => $this->keywords,
            'active' => $this->active,
            'business_id'   => $this->business_id
        ];
    }
}