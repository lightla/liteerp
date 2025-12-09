<?php

namespace Core\Business\Domain\Entities;

class Business
{
    public function __construct(
        public string $name,
        public string $address,
        public ?bool $active = false,
        public ?int $user_id = null,
        public ?int $id = null
    ) {}

    /**
     * Create Business entity from array (hydration).
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name:     $data['name'],
            address:  $data['address'],
            active:   $data['active'] ?? false,
            user_id:  $data['user_id'] ?? null,
            id:       $data['id'] ?? null
        );
    }

    /**
     * Convert entity to array (serialization).
     */
    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'address'  => $this->address,
            'active'   => $this->active,
            'user_id'  => $this->user_id,
        ];
    }
}
