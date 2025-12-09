<?php

namespace Core\StockMovementOut\Domain\Services;

use Core\StockMovementOut\Domain\Entities\StockMovementOut;

interface StockMovementOutService
{
    public function create(array $data): StockMovementOut;
    public function update(array $data): StockMovementOut;
    public function show(array $data): StockMovementOut;
    public function findById(array $data) : StockMovementOut;
    public function index(array $data): array;
    public function indexWithLimit(array $data): array;
}