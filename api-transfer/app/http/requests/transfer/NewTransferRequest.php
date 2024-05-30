<?php

namespace App\http\requests\transfer;

use Illuminate\Foundation\Http\FormRequest;

class NewTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value' => 'required|numeric',
            'payer' => 'required|integer',
            'payee' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'The value field is required.',
            'value.numeric' => 'The value must be a number.',
            'payer.required' => 'The payer field is required.',
            'payer.integer' => 'The payer must be an integer.',
            'payee.required' => 'The payee field is required.',
            'payee.integer' => 'The payee must be an integer.',
        ];
    }
}
