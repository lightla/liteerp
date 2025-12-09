<?php

namespace Core\Ordershipping\Domain\Repositories;

use Core\Ordershipping\Domain\Entities\OrderShipping;

interface OrderShippingRepositoryInterface
{
    public function create(OrderShipping $entity): OrderShipping;
    public function findById(array $data): ?OrderShipping;
    public function findByIdWithFullData(array $data): ?array;
    public function findByOrderId(array $data): ?OrderShipping;
    public function show(array $data) : ?array;
    public function index(array $data) : array;
    public function update(OrderShipping $entity) : OrderShipping;
}