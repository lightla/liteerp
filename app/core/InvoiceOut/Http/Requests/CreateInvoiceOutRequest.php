<?php

namespace Core\InvoiceOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Core\InvoiceOut\Application\DTOs\CreateInvoiceOutRequest as CreateInvoiceOutDTO;

class CreateInvoiceOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'document_no'  => 'required|string|max:255|unique:invoice_outs,document_no',
            'order_id'     => 'nullable|integer|exists:orders,id',

            'subtotal'     => 'nullable|numeric|min:0',
            'tax'          => 'nullable|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
            'total'        => 'nullable|numeric|min:0',

            'payment_status'       => 'required|in:paid,partial_payment,pending',

            'invoice_date' => 'required|date_format:Y-m-d',
            'due_date'     => 'nullable|date_format:Y-m-d',
            'approved'     => 'required|boolean' 
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
