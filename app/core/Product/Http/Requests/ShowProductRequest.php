<?php

namespace Core\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowProductRequest extends FormRequest
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
