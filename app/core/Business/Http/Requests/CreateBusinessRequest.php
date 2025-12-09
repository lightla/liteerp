<?php

namespace Core\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBusinessRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150|unique:business,name',
            'address' => 'required|string|max:250',
            'tax_code'  => 'required|string|max:200',
            'phone'  => 'required|string|max:12',
            'email'  => 'required|email|max:150',
            'logo_url'  => 'nullable|string|max:250',
            'bank_name'  => 'required|string|max:200',
            'bank_account_number'  => 'required|string|max:200',
            'bank_account_name'  => 'required|string|max:200'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}