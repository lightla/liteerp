<?php

namespace Core\Warehouse\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWarehouseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'address' => 'required|string|max:255',
            'active'  => 'nullable|boolean'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}