<?php

namespace Core\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowOrderRequest extends FormRequest
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
