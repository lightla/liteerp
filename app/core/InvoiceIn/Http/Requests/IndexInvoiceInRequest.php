<?php

namespace Core\InvoiceIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexInvoiceInRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_status' => 'nullable|in:pending,partial_payment,paid',
            'keywords' => 'nullable|string|max:150',
            'order_by' => 'nullable|in:DESC,ASC'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
