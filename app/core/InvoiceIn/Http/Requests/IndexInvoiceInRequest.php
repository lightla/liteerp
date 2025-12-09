<?php

namespace Core\InvoiceIn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexInvoiceInRequest extends FormRequest
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
