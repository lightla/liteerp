<?php

namespace Core\Customer\Application\UseCases;

use Core\Customer\Application\DTOs\CreateCustomerRequest;
use Core\Customer\Application\DTOs\IndexCustomerRequest;
use Core\Customer\Domain\Services\CustomerService;

class IndexCustomer
{
    public function __construct(private CustomerService $service) {}

    public function handle(IndexCustomerRequest $dto)
    {
        return $this->service->index($dto->toArray());
    }
}