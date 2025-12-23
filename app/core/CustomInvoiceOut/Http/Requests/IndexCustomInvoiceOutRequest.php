<?php

namespace Core\CustomInvoiceOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCustomInvoiceOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'approved'       => 'nullable|boolean',
            'payment_status' => 'nullable|in:paid,partial_payment,pending',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
