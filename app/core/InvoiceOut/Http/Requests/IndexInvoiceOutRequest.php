<?php

namespace Core\InvoiceOut\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Core\InvoiceOut\Application\DTOs\CreateInvoiceOutRequest as CreateInvoiceOutDTO;

class IndexInvoiceOutRequest extends FormRequest
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
