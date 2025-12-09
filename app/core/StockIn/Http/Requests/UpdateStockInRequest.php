<?php

namespace Core\StockIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'import_date' => 'required|date_format:Y-m-d',
            'status'      => 'required|in:pending,received'
        ];
    }
}
