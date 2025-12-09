<?php

namespace Core\StockMovementIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexStockMovementInRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'stock_in_id'  => 'required|numeric|exists:stock_ins,id',
            'limit' => 'nullable|numeric|min:15|max:300'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}