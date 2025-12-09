<?php

namespace Core\CategoryProduct\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150',
                'regex:/^[\p{L}\p{N}\s]+$/u' 
            ],
            'description' => [
                'nullable',
                'string',
                'max:150',
                'regex:/^[\p{L}\p{N}\s]+$/u' 
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}