<?php

namespace Core\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id'        => 'required|exists:category_product,id,deleted_at,NULL',
            'sku'                => 'required|string|max:100',
            'name'               => 'required|string|max:255',
            'unit'               => 'required|in:pcs,set,box,carton,bag,pack,roll',

            'description'        => 'required|string|max:255',
            'image'              => 'nullable|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
