<?php

namespace Core\Supplier\Domain\Services;

use Core\Supplier\Domain\Entities\Supplier;

interface SupplierService
{
    public function create(array $data): Supplier;
    public function index(array $data): array;
    public function update(array $data): Supplier;
}