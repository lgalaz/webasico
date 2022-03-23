<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccountForm extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                'regex:/^[\s\w-]*$/',
                'min:5',
                'max:16',
                Rule::unique('accounts', 'name')->ignore($this->account),
            ]
        ];
    }
}
