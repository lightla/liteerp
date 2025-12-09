<?php

namespace Core\Shipping\Domain\Services;

use App\Exceptions\BadException;
use Core\Shipping\Domain\Entities\Shipping;

interface ShippingService
{
    public function create(array $data): Shipping | BadException;
    public function index(array $data) : array;
    public function show(array $data) : Shipping | BadException;
    public function update(array $data) : Shipping | BadException;
}