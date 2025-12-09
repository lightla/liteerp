<?php

namespace Core\BusinessRole\Application\UseCases;

use App\Exceptions\ForbiddenBiddenException;
use Core\BusinessRole\Application\DTOs\CheckRoleBusinessRoleRequest;
use Core\BusinessRole\Domain\Services\BusinessRoleService;
use Illuminate\Support\Facades\Log;

class CheckPermissionBusinessRole
{
    public function __construct(private BusinessRoleService $service) {}

    public function handle(CheckRoleBusinessRoleRequest $dto) : array
    {
        $role = $this->service->findOne([
            'business_id' => $dto->business_id,
            'user_id' => $dto->user_id
        ]);
        $roles = config('businessrole.roles.' . $role->role);
        if(!in_array($dto->action,$roles)) {
            throw new ForbiddenBiddenException(__("You have not permission " . $dto->action));
        }
        return $role->toArray();
    }
}