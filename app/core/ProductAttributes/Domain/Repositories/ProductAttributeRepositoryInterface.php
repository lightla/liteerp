<?php

namespace Core\ProductAttributes\Domain\Repositories;

use Core\ProductAttributes\Domain\Entities\ProductAttribute;

interface ProductAttributeRepositoryInterface
{
    public function create(array $entity): array;
    public function deleteByCategory(int $category_id): bool;
}