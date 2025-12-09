<?php

namespace Core\Inventory\Application\DTOs;

class GetInventoryByIdRequest
{
    public function __construct(
        public int $id,
        public int $business_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            business_id: $data['business_id']
        );
    }

    public function toArray(): array
    {
        return [
            'id'   => $this->id,
            'business_id'  => $this->business_id
        ];
    }
}
