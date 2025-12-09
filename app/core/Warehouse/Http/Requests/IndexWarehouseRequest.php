<?php

namespace Core\Warehouse\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexWarehouseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'active' => 'nullable|numeric|min:0|max:1',
            'keywords' => 'nullable|string|max:150',
            'limit'  => 'nullable|numeric|min:15|max:300'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}