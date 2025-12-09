<?php

namespace Core\Supplier\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexSupplierRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'active' => 'nullable|boolean'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
