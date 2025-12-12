<?php

namespace Core\CategoryProduct\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
    public function authorize(): bool
    {
        return true;
    }
}
