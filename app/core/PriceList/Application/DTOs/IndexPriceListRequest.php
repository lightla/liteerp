<?php

namespace Core\PriceList\Application\DTOs;

class IndexPriceListRequest
{
    public function __construct(
        public ?string $keywords = null,
        public int $created_by,
        public int $business_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            keywords: $data['keywords'],
            created_by: $data['user_id'],
            business_id: $data['business_id']
        );
    }

    public function toArray(): array
    {
        return [
            'keywords' => $this->keywords,
            'created_by'        => $this->created_by,
            'business_id'       => $this->business_id
        ];
    }
}
