<?php

namespace Core\CustomerGroup\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowCustomerGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'business_id' => 'required|integer|exists:business,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
