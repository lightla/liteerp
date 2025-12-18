<?php

namespace Core\OrderItem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteOrderItemRequest extends FormRequest
{
     public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return true;
    }
}
