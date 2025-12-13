<?php

namespace Core\Overview\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOverviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}