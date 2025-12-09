<?php

namespace Core\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'status' => 'nullable|in:pending,approved,invoiced,shipped,completed,cancelled'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
