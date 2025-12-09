<?php

namespace Core\Warehouse\Application\DTOs;

class ShowWarehouseRequest
{
    public function __construct(
        public ?int $id = null,
        public int $created_by,
        public int $busuness_id 
    ) {}
    public static function fromArray(array $data) : self {
        return new self(
            id: $data['id'] ?? null,
            created_by: $data['user_id'],
            busuness_id: $data['busuness_id']
        );
    }
    public function toArray(): array {
        return [
            'id'  => $this->id,
            'created_by' => $this->created_by,
            'busuness_id'   => $this->busuness_id
        ];
    }
}
