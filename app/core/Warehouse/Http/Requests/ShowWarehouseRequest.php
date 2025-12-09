<?php

namespace Core\Warehouse\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowWarehouseRequest extends FormRequest
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