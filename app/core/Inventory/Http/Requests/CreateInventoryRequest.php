<?php

namespace Core\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInventoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id'   => 'required|integer|exists:products,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'quantity'     => 'nullable|numeric|min:0',
            'reserved_qty' => 'nullable|numeric|min:0',
            'stock_in_id'  => 'nullable|exists:stock_ins,id',
            'stock_out_id'  => 'nullable|exists:stock_outs,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
