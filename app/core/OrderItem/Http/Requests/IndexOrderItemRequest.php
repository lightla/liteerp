<?php

namespace Core\OrderItem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexOrderItemRequest extends FormRequest
{
     public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'summary'  => 'nullable|boolean'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
