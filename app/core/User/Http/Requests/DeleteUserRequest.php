<?php

namespace Core\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
