<?php

namespace Core\OrderShipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexOrderShippingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id'               => 'required|integer|exists:orders,id|unique:shippings,order_id',

            'receiver_name'          => 'nullable|string|max:255',
            'receiver_phone'         => 'nullable|string|max:50',
            'receiver_address'       => 'nullable|string|max:500',
            'receiver_note'          => 'nullable|string',

            'preferred_unit'         => 'required|integer|exists:shipping_providers,id',

            'shipping_fee_estimated' => 'nullable|integer|min:0',
            'shipping_code'          => 'nullable|string|max:255',
            'shipping_fee_actual'    => 'nullable|integer|min:0',

            'status' => 'nullable|in:pending,packing,shipping,delivered,failed,cancelled',

            'shipped_at'    => 'nullable|date',
            'delivered_at'  => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
