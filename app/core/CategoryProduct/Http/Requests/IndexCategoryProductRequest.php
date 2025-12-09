<?php

namespace Core\CategoryProduct\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCategoryProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => [
                'nullable',
                'string',
                'max:150',
                'regex:/^[\p{L}\p{N}\s]+$/u' // chỉ cho phép chữ cái, số và khoảng trắng (hỗ trợ Unicode/tiếng Việt)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'keywords.regex' => 'Từ khóa chỉ được chứa chữ cái, số và khoảng trắng (không chứa ký tự đặc biệt).',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
