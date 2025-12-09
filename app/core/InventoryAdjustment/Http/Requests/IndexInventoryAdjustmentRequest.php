<?php

namespace Core\InventoryAdjustment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexInventoryAdjustmentRequest extends FormRequest
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