<?php

namespace Core\StockMovementOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexStockMovementOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'stock_out_id' => 'required|integer|exists:stock_outs,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
