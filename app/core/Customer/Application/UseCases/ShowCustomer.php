<?php

namespace Core\Customer\Application\UseCases;

use Core\Customer\Application\DTOs\ShowCustomerRequest;
use Core\Customer\Domain\Services\CustomerService;

class ShowCustomer
{
    public function __construct(private CustomerService $service) {}

    public function handle(ShowCustomerRequest $dto)
    {
        return $this->service->show($dto->toArray());
    }
}