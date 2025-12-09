<?php

namespace Core\Ordershipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderShippingRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('order_shipping');
        return [
            'order_id' => 'required|integer|exists:orders,id|unique:shippings,order_id,' . $id . ',id',

            'receiver_name'          => 'required|string|max:255',
            'receiver_phone'         => 'required|string|max:50',
            'receiver_address'       => 'required|string|max:500',
            'receiver_note'          => 'nullable|string',

            'preferred_unit'         => 'required|integer|exists:shipping_providers,id',

            'shipping_fee_estimated' => 'nullable|integer|min:0',
            'shipping_code'          => 'nullable|string|max:255',
            'shipping_fee_actual'    => 'nullable|integer|min:0',

            'shipped_at'    => 'nullable|date',
            'delivered_at'  => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
