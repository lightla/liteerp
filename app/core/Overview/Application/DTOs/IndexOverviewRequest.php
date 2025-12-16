<?php

namespace Core\Overview\Application\DTOs;

class IndexOverviewRequest
{
    public function __construct(
        private int $business_id,
        private int $created_by
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            business_id: $data['business_id'],
            created_by: $data['user_id']
        );
    }
    public function toArray(){
        return [
            'business_id' => $this->business_id,
            'created_by'  => $this->created_by
        ];
    }
}