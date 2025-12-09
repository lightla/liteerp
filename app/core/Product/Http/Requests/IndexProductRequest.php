<?php

namespace Core\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'nullable|numeric|min:0',
            'keywords' => 'nullable|string|max:150',
            'purchase_id' => 'nullable|exists:purchases,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
