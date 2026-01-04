<?php

namespace Core\BusinessRole\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\BusinessRole\Application\DTOs\CreateBusinessRoleRequest;
use Core\BusinessRole\Domain\Services\BusinessRoleService;

class UpdateBusinessRole
{
    public function __construct(private BusinessRoleService $service,
        private HookDispatcher $hooks) {}

    public function handle(CreateBusinessRoleRequest $dto)
    {
        $roles = config('businessrole.roles.' . $dto->role);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: [
                    ...$dto->toArray(),
                    'roles' => $roles
                ],
                module: 'BusinessRole'
            )
        );
        $update = $this->service->update($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$data,
                    'business_role' => $update->toArray()
                ],
                module: 'BusinessRole'
            )
        );
        return $data;
    }
}