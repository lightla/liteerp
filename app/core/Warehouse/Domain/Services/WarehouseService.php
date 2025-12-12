<?php

namespace Core\Warehouse\Domain\Services;

use App\Exceptions\BadException;
use Core\Warehouse\Application\DTOs\CreateWarehouseRequest;
use Core\Warehouse\Domain\Entities\Warehouse;

interface WarehouseService
{
    public function create(array $data): Warehouse | BadException;
    public function index(array $data) : array;
    public function show(array $data) : Warehouse;
    public function update(array $data): Warehouse | BadException;
    public function delete(array $data): Warehouse | BadException;
}