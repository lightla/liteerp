<?php

namespace Core\PurchaseItem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexPurchaseItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'purchase_id' => 'required|exists:purchases,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}