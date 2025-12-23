<?php

namespace Core\CustomInvoiceOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomInvoiceOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description'    => 'required|string|max:500',
            'amount'         => 'required|numeric|min:0',
            'invoice_date'   => 'required|date',
            'approved'       => 'nullable|boolean',
            'payment_status' => 'sometimes|in:paid,partial_payment,pending',
            'document_no' => 'nullable|max:150',
            'customer_id'    => 'nullable|exists:customers,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
