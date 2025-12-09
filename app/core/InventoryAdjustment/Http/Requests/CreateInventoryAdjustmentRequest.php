<?php

namespace Core\InventoryAdjustment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInventoryAdjustmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id'   => 'required|integer|exists:products,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'qty_adjusted' => 'required|numeric',
            'reason'       => 'required|string|max:250'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}