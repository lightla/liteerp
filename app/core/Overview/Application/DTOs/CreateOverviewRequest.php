<?php

namespace Core\Overview\Application\DTOs;

class CreateOverviewRequest
{
    public function __construct(
        public string $name,
        public ?string $description = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null
        );
    }
}