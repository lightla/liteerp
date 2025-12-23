<?php

namespace Core\CustomInvoiceIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomInvoiceInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|integer|exists:suppliers,id',

            'document_no' => 'nullable|string|max:100',

            'description' => 'required|string|max:500',

            'amount' => 'required|numeric|min:0',

            'invoice_date' => 'required|date',

            'payment_status' => 'required|in:paid,partial_payment,pending',
            'approved'  => 'required|boolean'
        ];
    }
}
