<?php

namespace Core\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_date'  => 'required|date_format:Y-m-d',
            'expected_date'  => 'required|date_format:Y-m-d|after_or_equal:purchase_date',
            'note'           => 'nullable|string|max:1000',
            'shipping_fee'   => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank,transfer,other',
            'status'         => 'required|in:draft,requested,approved,cancelled'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
