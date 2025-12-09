<?php

namespace Core\StockOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowStockOutRequest extends FormRequest
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
