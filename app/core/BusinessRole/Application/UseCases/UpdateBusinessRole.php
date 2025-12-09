<?php

namespace Core\BusinessRole\Application\UseCases;

use Core\BusinessRole\Application\DTOs\CreateBusinessRoleRequest;
use Core\BusinessRole\Domain\Services\BusinessRoleService;

class UpdateBusinessRole
{
    public function __construct(private BusinessRoleService $service) {}

    public function handle(CreateBusinessRoleRequest $dto)
    {
        return $this->service->update($dto->toArray());
    }
}