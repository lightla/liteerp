<?php

namespace Core\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexInventoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'isOrder' => 'nullable|numeric|min:0|max:1'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
