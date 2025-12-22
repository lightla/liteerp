<?php

namespace Core\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexPurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'status' => 'nullable|in:draft,requested,approved,cancelled',
            'order_by' => 'nullable|in:ASC,DESC'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
