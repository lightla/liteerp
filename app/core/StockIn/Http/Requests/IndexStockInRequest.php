<?php

namespace Core\StockIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexStockInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'status' => 'nullable|in:received,pending,cancelled'
        ];
    }
}
