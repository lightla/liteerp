<?php

namespace Core\Inventory\Application\DTOs;

class IndexInventoryRequest
{
    public function __construct(
        public ?string $keywords = null,
        public ?int $customer_group_id = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            keywords: $data['keywords'] ?? null,
            customer_group_id: $data['customer_group_id'] ?? null  
        );
    }

    public function toArray(): array
    {
        return [
            'keywords' => $this->keywords,
            'customer_group_id' => $this->customer_group_id
        ];
    }
}
