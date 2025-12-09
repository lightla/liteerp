<?php

namespace Core\Warehouse\Domain\Services;

use Core\Warehouse\Application\DTOs\CreateWarehouseRequest;
use Core\Warehouse\Domain\Entities\Warehouse;

interface WarehouseService
{
    public function create(array $data): Warehouse;
    public function index(array $data) : array;
    public function show(array $data) : Warehouse;
    public function update(array $data): Warehouse;
}