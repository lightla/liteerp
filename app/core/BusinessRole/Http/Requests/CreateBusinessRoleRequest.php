<?php

namespace Core\BusinessRole\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBusinessRoleRequest extends FormRequest
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