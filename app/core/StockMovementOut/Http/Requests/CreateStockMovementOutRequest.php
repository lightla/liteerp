<?php

namespace Core\StockMovementOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStockMovementOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id'   => 'required|integer|exists:products,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'qty_change'   => 'required|numeric|min:0.01',
            'stock_out_id' => 'required|integer|exists:stock_outs,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
