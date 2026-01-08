<?php

namespace Core\BusinessRole\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\BusinessRole\Application\DTOs\DeleteBusinessRoleRequest;
use Core\BusinessRole\Domain\Services\BusinessRoleService;

class DeleteBusinessRole
{
    public function __construct(private BusinessRoleService $service,
        private HookDispatcher $hooks) {}

    public function handle(DeleteBusinessRoleRequest $dto)
    {
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::DELETE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: [
                    ...$dto->toArray()
                ],
                module: 'BusinessRole'
            )
        );
        $delete = $this->service->delete($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::DELETE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$data,
                    'business_role' => $delete->toArray()
                ],
                module: 'BusinessRole'
            )
        );
        return $data;
    }
}