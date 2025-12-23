<?php

namespace Core\CustomInvoiceIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCustomInvoiceInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'keywords' => 'nullable|string|max:150',
            'order_by' => 'nullable|in:ASC,DESC',
            'payment_status' => 'nullable|in:paid,partial_payment,pending',
        ];
    }
}
