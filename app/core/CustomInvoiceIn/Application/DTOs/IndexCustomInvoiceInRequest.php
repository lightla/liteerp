<?php

namespace Core\CustomInvoiceIn\Application\DTOs;

class IndexCustomInvoiceInRequest
{
    public function __construct(
        public int $business_id,
        public int $created_by,
        public ?string $order_by = null,
        public ?string $keywords = null,
        public ?string $payment_status = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            business_id: (int) $data['business_id'],
            created_by: (int) $data['user_id'],
            keywords: $data['keywords'] ?? null,
            payment_status: $data['payment_status'] ?? null,
            order_by: $data['order_by'] ?? 'DESC'
        );
    }

    public function toArray(): array
    {
        return [
            'business_id' => $this->business_id,
            'created_by' => $this->created_by,
            'keywords' => $this->keywords,
            'payment_status' => $this->payment_status,
            'order_by'  => $this->order_by
        ];
    }
}
