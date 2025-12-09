<?php

namespace Core\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexShippingRequest extends FormRequest
{
     public function rules(): array
    {
        return [
            'page' => 'required|numeric|min:0',
            'keywords' => 'nullable|string|max:150'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}