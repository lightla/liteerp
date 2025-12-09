<?php

namespace Core\Supplier\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'unit_name'     => 'required|string|max:150',
            'email'         => 'nullable|email|max:150',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:150',
            'tax_code'      => 'required|string|max:50',
            'bank_name'     => 'nullable|string|max:150',
            'bank_account'  => 'nullable|string|max:100',
            'website'       => 'nullable|url|max:150',
            'note'          => 'nullable|string|max:250',
            'active'        => 'required|boolean'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
