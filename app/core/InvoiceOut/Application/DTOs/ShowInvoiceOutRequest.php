<?php

namespace Core\InvoiceOut\Application\DTOs;

class ShowInvoiceOutRequest
{
    public function __construct(
        public int $business_id,
        public ?int $id = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            business_id: (int)$data['business_id'],
            id: $data['id'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'business_id'  => $this->business_id,
            'id' => $this->id
        ];
    }
}
