<?php

namespace Core\CategoryProduct\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'description' => 'required|string|max:250',
            'tax' => 'required|numeric|min:0|max:100'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}