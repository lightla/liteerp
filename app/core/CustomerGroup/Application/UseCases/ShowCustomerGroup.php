<?php

namespace Core\CustomerGroup\Application\UseCases;

use Core\CustomerGroup\Application\DTOs\CreateCustomerGroupRequest;
use Core\CustomerGroup\Domain\Services\CustomerGroupService;

class ShowCustomerGroup
{
    public function __construct(private CustomerGroupService $service) {}

    public function handle(array $dto)
    {
        return $this->service->show($dto);
    }
}