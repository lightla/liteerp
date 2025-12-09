<?php

namespace Core\Customer\Application\DTOs;

class IndexCustomerRequest
{
    public function __construct(
        public ?string $type,
        public ?string $keywords,
        public ?string $business_id
    ) {}
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'] ?? null,
            keywords: $data['keywords'] ?? null,
            business_id: $data['business_id']
        );
    }
    public function toArray(): array
    {
        return [
            'type'  => $this->type,
            'keywords'         => $this->keywords,
            'business_id'   => $this->business_id
        ];
    }
}
