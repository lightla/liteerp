<?php

namespace Core\Overview\Domain\Entities;

class Overview
{
    public function __construct(
        public string $name,
        public ?string $description = null
    ) {}
}