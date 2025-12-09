<?php

namespace Core\PriceList\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_group_id' => 'required|integer|exists:customer_group,id',
            'product_id'        => 'required|integer|exists:products,id',
            'price'             => 'required|numeric|min:0',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
