<?php

namespace Core\Inventory\Domain\Services;

use App\Exceptions\BadException;
use Core\Inventory\Domain\Entities\Inventory;

interface InventoryService
{
    public function create(array $data): Inventory | BadException;
    public function update(array $data) : Inventory | BadException;
    public function updateById(array $data) : Inventory | BadException;
    public function show(array $data) : Inventory | BadException;
    public function index(array $data) : array;
    public function findById(array $data) : Inventory | BadException;
    public function getById(array $data) : ?Inventory;
    public function getByOneByProductAndWarehouse(array $data) : ?Inventory;
}