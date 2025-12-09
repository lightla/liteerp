<?php

namespace Core\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingRequest extends FormRequest
{
     public function rules(): array
    {
        return [
            'name'   => 'required|string|max:150',
            'code'   => 'required|string|max:100',
            'logo'   => 'nullable|string|max:255',
            'active' => 'required|boolean'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}