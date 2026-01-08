<?php

namespace Core\BusinessRole\Domain\Services;

use App\Exceptions\BadException;
use Core\BusinessRole\Domain\Entities\BusinessRole;

interface BusinessRoleService
{
    public function create(array $data): BusinessRole | BadException;
    public function update(array $data): BusinessRole | BadException;
    public function findOne(array $data): BusinessRole | BadException;
    public function listUserByRole(array $data): array;
    public function delete(array $data): BusinessRole | BadException;
}