<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'domain' => [
                'required',
                'domain',
                'max:100',
            ],
            'protocol' => [
                'required',
                Rule::in(['http', 'https']),
                'max:20',
            ],
            'whitelisted_domain_entities' => [
                'array',
                'required',
            ],
            'whitelisted_domain_entities.*.domain' => [
                'domain',
            ],
            'whitelisted_domain_entities.*.protocol' => [
                'required',
                'max:20',
            ],
        ];
    }
}
