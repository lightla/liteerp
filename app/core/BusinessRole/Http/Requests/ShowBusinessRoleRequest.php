<?php

namespace Core\BusinessRole\Http\Requests;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Illuminate\Foundation\Http\FormRequest;

class ShowBusinessRoleRequest extends FormRequest
{
    public function rules(HookDispatcher $hooks): array
    {
        $hooks = $hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::VALIDATE,
                timing: HookTiming::ON,
                payload: [],
                module: 'BusinessRole'
            )
        );
        return [
            ...$hooks,
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}