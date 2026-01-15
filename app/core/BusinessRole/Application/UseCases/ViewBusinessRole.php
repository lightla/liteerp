<?php 
namespace Core\BusinessRole\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\BusinessRole\Application\DTOs\ShowBusinessRoleRequest;
use Core\BusinessRole\Domain\Services\BusinessRoleService;
use Core\BusinessRole\Infrastructure\Helpers\SupportUINav;

class ViewBusinessRole {
    public function __construct(private BusinessRoleService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        $dto = ShowBusinessRoleRequest::fromArray($data);
        $role = $this->service->findOne([
            'business_id' => $dto->business_id,
            'role_user_id' => $dto->user_id
        ]);
        $roles = config('businessrole.roles.' . $role->role);
        $nav = config('businessrole.nav');
        $nav = SupportUINav::build($nav,$roles);
        $index = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::UI,
                timing: HookTiming::ON,
                payload: [
                    ...$data,
                    'roles' => $roles,
                    'nav' => $nav
                ],
                module: 'BusinessRole'
            )
        );
        return [
            ...$index
        ];
    }
}