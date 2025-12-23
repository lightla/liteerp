<?php

namespace Core\CustomInvoiceOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCustomInvoiceOutRequest extends FormRequest
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
