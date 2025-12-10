<?php

namespace Core\OrderShipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowOrderShippingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
