<?php

namespace Core\InvoiceOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexInvoiceOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => 'nullable|string|max:150',
            'payment_status' => 'nullable|in:paid,partial_payment,pending',
            'order_by' => 'nullable|in:ASC,DESC'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
