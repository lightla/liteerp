<?php

namespace Core\CustomerGroup\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'business_id' => 'required|integer|exists:business,id',
            'name'        => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
