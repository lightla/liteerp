<?php

namespace Core\StockOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,shipped,completed',
            'order_id'  => 'required|numeric|exists:orders,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
