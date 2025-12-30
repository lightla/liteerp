<?php

namespace Core\CategoryProduct\Http\Requests;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryProductRequest extends FormRequest
{
    public function rules(HookDispatcher $hooks): array
    {
        return [
            ...$hooks->dispatch(
                new HookContext(
                    action: HookAction::CREATE,
                    phase: HookPhase::VALIDATE,
                    timing: HookTiming::ON,
                    payload: [],
                    module: 'CategoryProduct'
                )
            ),
            'name' => 'required|string|max:150',
            'description' => 'required|string|max:250',
            'tax' => 'required|numeric|min:0|max:100',
            'attributes' => 'nullable|array',
            'attributes.*.key' => 'required|string|max:50',
            'attributes.*.type' => 'required|string|in:text,number,date,textarea',
            'attributes.*.value' => 'nullable|string|max:150',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
            'attributes.*.value.max' => 'The value is too long. It shuold be max 150 characters',
            'attributes.*.value.required' => 'The value is required.',
        ];
    }
}
