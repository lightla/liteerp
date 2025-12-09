<?php

namespace Core\Customer\Domain\Services;

use App\Exceptions\BadException;
use Core\Customer\Domain\Entities\Customer;

interface CustomerService
{
    public function create(array $data): Customer | BadException;
    public function index(array $data): array;
    public function update(array $data): Customer | BadException;
    public function show(array $data) : Customer | BadException;
}