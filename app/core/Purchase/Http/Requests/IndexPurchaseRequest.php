<?php

namespace Core\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexPurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'status' => 'nullable|in:draf,requested,approved,paid,received,cancelled',
            'page' => 'nullable|numeric|min:0'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
