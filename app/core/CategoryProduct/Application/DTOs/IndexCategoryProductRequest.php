<?php

namespace Core\CategoryProduct\Application\DTOs;

class IndexCategoryProductRequest
{
    public function __construct(
        public ?string $keywords,
        public int $created_by,
        public int $business_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            keywords: $data['keywords'],
            business_id: $data['business_id'],
            created_by: $data['user_id'] ?? null
        );
    }
    public function toArray() : array {
        return [
            'keywords' => $this->keywords,
            'business_id' => $this->business_id,
            'created_by' => $this->created_by,
        ];
    }
}