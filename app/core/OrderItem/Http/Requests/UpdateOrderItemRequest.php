<?php

namespace Core\OrderItem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemRequest extends FormRequest
{
     public function rules(): array
    {
        return [
            'order_id'               => 'required|integer|exists:orders,id',
            'inventory_id'             => 'required|integer|exists:inventories,id',
            'discount'               => 'nullable|numeric|min:0',

            'buy_quantity'           => 'nullable|numeric|min:0',
            'gift_quantity'          => 'nullable|numeric|min:0',
            'compensation_quantity'  => 'nullable|numeric|min:0',
            'conversion_quantity'    => 'nullable|numeric|min:0',

            'price'                  => 'required|numeric|min:0',
            'tax'                    => 'required|numeric|min:0',
        ];
    }

    /**
     * Custom quantity validation rule
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $buy  = (float) ($this->buy_quantity ?? 0);
            $gift = (float) ($this->gift_quantity ?? 0);
            $comp = (float) ($this->compensation_quantity ?? 0);
            $conv = (float) ($this->conversion_quantity ?? 0);

            if ($buy <= 0 && $gift <= 0 && $comp <= 0 && $conv <= 0) {
                $validator->errors()->add(
                    'quantity',
                    'At least one quantity field must be greater than 0.'
                );
            }
        });
    }

    public function authorize(): bool
    {
        return true;
    }
}
