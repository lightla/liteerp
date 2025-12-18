<?php

namespace Core\PurchaseItem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeletePurchaseItemRequest extends FormRequest
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