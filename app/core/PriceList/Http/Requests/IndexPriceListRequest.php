<?php

namespace Core\PriceList\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexPriceListRequest extends FormRequest
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
