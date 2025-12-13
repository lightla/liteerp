<?php

namespace Core\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id'        => 'required|exists:category_product,id,deleted_at,NULL',
            'description'        => 'required|string|max:255',
            'image'              => 'nullable|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
