<?php

namespace Core\CustomerGroup\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCustomerGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
