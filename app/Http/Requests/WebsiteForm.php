<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WebsiteForm extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'regex:/^[\s\w-]*$/',
                'min:3',
                'max:16',
                Rule::unique('websites')
                    ->ignore($this->website)
                    ->where(function ($query) {
                        return $query->where('account_id', '=', $this->account->account_id)
                            ->whereNull('deleted_at');
                    })
            ],
            'template_id' => [
                'exists:templates,template_id'
            ]
        ];
    }
}
