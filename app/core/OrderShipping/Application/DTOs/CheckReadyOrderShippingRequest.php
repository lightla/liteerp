<?php

namespace Core\OrderShipping\Application\DTOs;

class CheckReadyOrderShippingRequest
{
    public function __construct(
        public int $order_id,
        public int $business_id,
        public ?int $created_by = null
    ) {}

    /**
     * Nhận dữ liệu từ FormRequest
     */
    public static function fromArray(array $data): self
    {
        return new self(
            order_id: $data['order_id'],
            business_id: $data['business_id'],
            created_by: $data['user_id']
        );
    }

    /**
     * Convert DTO → array để lưu DB
     */
    public function toArray(): array
    {
        return [
            'order_id'               => $this->order_id,
            'business_id'   => $this->business_id,
            'created_by'    => $this->created_by
        ];
    }
}
