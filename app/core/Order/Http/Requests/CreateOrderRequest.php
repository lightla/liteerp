<?php

namespace Core\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'customer_id'   => 'required|integer|exists:customers,id',
            'order_date' => 'required|date',
            'order_no' => 'nullable|string|max:150',
            'expected_delivery_date' => 'required|date|after_or_equal:order_date',
            'note'        => 'nullable|string',

            'type'        => 'required|in:retail,wholesale',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
