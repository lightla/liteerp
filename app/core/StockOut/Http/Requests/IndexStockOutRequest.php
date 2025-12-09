<?php

namespace Core\StockOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexStockOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'status' => 'nullable|in:invoiced,shipped'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
