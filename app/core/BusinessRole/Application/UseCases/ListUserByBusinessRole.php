<?php

namespace Core\BusinessRole\Application\UseCases;

use Core\BusinessRole\Application\DTOs\ListUserByBusinessRoleRequest;
use Core\BusinessRole\Domain\Services\BusinessRoleService;

class ListUserByBusinessRole
{
    public function __construct(private BusinessRoleService $service) {}

    public function handle(ListUserByBusinessRoleRequest $dto) : array
    {
        return $this->service->listUserByRole([
            'business_id' => $dto->business_id,
            'role' => $dto->role,
            'created_by' => $dto->created_by
        ]);
    }
}