<?php

namespace Core\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexInventoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'customer_group_id' => 'nullable|numeric|exists:customer_group,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
