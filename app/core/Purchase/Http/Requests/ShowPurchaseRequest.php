<?php

namespace Core\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowPurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
