<?php

namespace Core\Inventory\Domain\Repositories;

use Core\Inventory\Domain\Entities\Inventory;

interface InventoryRepositoryInterface
{
    public function create(Inventory $entity): Inventory;
    public function update(Inventory $entity): Inventory;
    public function findByOneByProductAndWarehouse(array $data): ?Inventory;
    public function findById(array $data): ?Inventory;
    public function index(array $data) : array;
}