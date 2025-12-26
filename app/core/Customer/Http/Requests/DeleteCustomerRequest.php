<?php

namespace Core\Customer\Http\Requests;

use App\Contracts\Hooks\HookAction;
use App\Contracts\Hooks\HookContext;
use App\Contracts\Hooks\HookPhase;
use App\Contracts\Hooks\HookTiming;
use App\Supports\Hooks\HookDispatcher;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCustomerRequest extends FormRequest
{
    public function rules(HookDispatcher $hooks): array
    {
        $hooks = $hooks->dispatch(
            new HookContext(
                action: HookAction::DELETE,
                phase: HookPhase::VALIDATE,
                timing: HookTiming::ON,
                payload: [],
                module: 'Customer'
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
