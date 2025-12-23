<?php

namespace Core\CustomInvoiceOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomInvoiceOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description'    => 'required|string|max:500',
            'amount'         => 'required|numeric|min:0',
            'invoice_date'   => 'required|date',
            'approved'       => 'nullable|boolean',
            'payment_status' => 'sometimes|in:paid,partial_payment,pending',
            'document_no' => 'nullable|max:150'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
