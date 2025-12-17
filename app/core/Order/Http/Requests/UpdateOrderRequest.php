<?php

namespace Core\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_date' => 'date',
            'expected_delivery_date' => 'date|after_or_equal:order_date',
            'order_no' => 'required|string|max:150',
            'note'        => 'nullable|string',

            'type'        => 'nullable|in:retail,wholesale',
            'status' => 'nullable|in:pending,approved,cancelled',
            'reason' => 'nullable|string|max:250'    
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
