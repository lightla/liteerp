<?php

namespace Core\ProductAttributes\Domain\Repositories;

use Core\ProductAttributes\Domain\Entities\ProductAttribute;

interface ProductAttributeRepositoryInterface
{
    public function create(ProductAttribute $entity): ProductAttribute;
}