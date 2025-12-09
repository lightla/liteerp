<?php

namespace Core\StockIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowStockInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            
        ];
    }
}
