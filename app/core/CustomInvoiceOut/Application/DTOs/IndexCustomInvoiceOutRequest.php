<?php

namespace Core\CustomInvoiceOut\Application\DTOs;

class IndexCustomInvoiceOutRequest
{
    public function __construct(
        public int $createdBy,
        public int $business_id,
        public ?bool $approved = null,
        public ?string $paymentStatus = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            createdBy: (int) $data['user_id'],
            business_id: (int) $data['business_id'],
            approved: $data['approved'] ?? null,
            paymentStatus: $data['payment_status'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'created_by' => $this->createdBy,
            'business_id' => $this->business_id,
            'approved' => $this->approved,
            'payment_status' => $this->paymentStatus,
        ];
    }
}
