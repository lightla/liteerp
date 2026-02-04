<?php

namespace Core\BusinessRole\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\BusinessRole\Application\DTOs\CreateBusinessRoleRequest;
use Core\BusinessRole\Application\DTOs\ShowBusinessRoleRequest;
use Core\BusinessRole\Domain\Services\BusinessRoleService;

class ShowBusinessRole
{
    public function __construct(private BusinessRoleService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::SHOW,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'BusinessRole'
            )
        );
        $dto = ShowBusinessRoleRequest::fromArray($data);
        $role = $this->service->findOne([
            'business_id' => $dto->business_id,
            'role_user_id' => $dto->user_id
        ]);
        $roles = config('businessrole.roles.' . $role->role);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::SHOW,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    'roles' => $roles,
                    'business_role' => $role->toArray(),
                    ...$data 
                ],
                module: 'BusinessRole'
            )
        );
        return $data;
    }
}