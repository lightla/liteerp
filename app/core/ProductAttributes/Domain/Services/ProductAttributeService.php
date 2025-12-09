<?php

namespace Core\ProductAttributes\Domain\Services;

use Core\ProductAttributes\Domain\Entities\ProductAttribute;

interface ProductAttributeService
{
    public function create(array $data): ?ProductAttribute;
}