<?php

namespace Core\Inventory\Application\DTOs;

class IndexInventoryRequest
{
    public function __construct(
        private ?string $keywords = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            keywords: $data['keywords'] ?? null 
        );
    }

    public function toArray(): array
    {
        return [
            'keywords' => $this->keywords
        ];
    }
}
