<?php

namespace Core\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowBusinessRequest extends FormRequest
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