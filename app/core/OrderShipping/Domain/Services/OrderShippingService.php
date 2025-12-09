<?php

namespace Core\Ordershipping\Domain\Services;

use App\Exceptions\BadException;
use Core\Ordershipping\Domain\Entities\OrderShipping;

interface OrderShippingService
{
    public function create(array $data): OrderShipping | BadException;
    public function index(array $data) : array;
    public function show(array $data) : array | BadException;
    public function findByOrderId(array $data) : OrderShipping | BadException;
    public function update(array $data) : OrderShipping | BadException;
}