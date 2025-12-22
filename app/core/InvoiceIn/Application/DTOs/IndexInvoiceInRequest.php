<?php

namespace Core\InvoiceIn\Application\DTOs;

class IndexInvoiceInRequest
{
    public function __construct(
        public int $business_id,
        public ?string $keywords = null,
        public ?string $payment_status = null, 
        public int $created_by,
        public ?string $order_by = null, 
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            business_id: $data['business_id'],
            keywords: $data['keywords'] ?? null,
            payment_status: $data['payment_status'] ?? null,
            created_by: $data['user_id'] ?? null,
            order_by: $data['order_by'] ?? 'DESC' 
        );
    }

    public function toArray(): array
    {
        return [
            'business_id' => $this->business_id,
            'payment_status' => $this->payment_status,
            'keywords'    => $this->keywords,
            'created_by'    => $this->created_by,
            'order_by'  => $this->order_by
        ];
    }
}
