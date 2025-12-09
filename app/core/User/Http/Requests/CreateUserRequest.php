<?php

namespace Core\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:150',
            'role' => 'required|in:manager,seller,accountanter,warehouseman,purchaser,admin'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
