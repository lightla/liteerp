<?php

namespace Core\Shipping\Application\DTOs;

class IndexShippingRequest
{
    public function __construct(
        public ?bool $active = null,
        public ?string $keywords = null,
        public int $business_id,
        public int $created_by  
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            active: $data['active'] ?? false,
            business_id: $data['business_id'],
            keywords: $data['keywords'],
            created_by: $data['user_id'] 
        );
    }

    public function toArray(): array
    {
        return [
            'active' => $this->active,
            'business_id' => $this->business_id,
            'keywords'     => $this->keywords,
            'created_by'    => $this->created_by
        ];
    }
}