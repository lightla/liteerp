<?php

namespace Core\BusinessRole\Domain\Repositories;

use Core\BusinessRole\Domain\Entities\BusinessRole;

interface BusinessRoleRepositoryInterface
{
    public function create(BusinessRole $entity): BusinessRole;
    public function findOne(array $data): ?BusinessRole;
    public function listUserByRole(array $data): array;
    public function update(BusinessRole $entity) : BusinessRole;
}