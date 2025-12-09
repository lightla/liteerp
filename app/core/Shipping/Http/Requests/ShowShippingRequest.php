<?php

namespace Core\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowShippingRequest extends FormRequest
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