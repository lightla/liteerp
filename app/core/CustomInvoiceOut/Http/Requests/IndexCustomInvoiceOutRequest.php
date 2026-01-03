<?php

namespace Core\CustomInvoiceOut\Http\Requests;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Illuminate\Foundation\Http\FormRequest;

class IndexCustomInvoiceOutRequest extends FormRequest
{
    public function rules(HookDispatcher $hooks): array
    {
        $hooks = $hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::VALIDATE,
                timing: HookTiming::ON,
                payload: [],
                module: 'CustomInvoiceOut'
            )
        );
        return [
            ...$hooks,
            'approved'       => 'nullable|boolean',
            'payment_status' => 'nullable|in:paid,partial_payment,pending',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
