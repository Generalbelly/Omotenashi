<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'whitelisted_domain_entities.*.id' => [
                'nullable',
                'uuid',
            ],
            'whitelisted_domain_entities.*.domain' => [
                'domain',
            ],
            'whitelisted_domain_entities.*.protocol' => [
                'required',
                Rule::in(['http', 'https']),
                'max:20',
            ],
            'google_analytics_property_entities' => [
                'array',
            ],
            'google_analytics_property_entities.*.account_id' => [
                implode(',', [
                    'required_with:google_analytics_property_entities.*.account_name',
                    'google_analytics_property_entities.*.property_id',
                    'google_analytics_property_entities.*.property_name',
                    'google_analytics_property_entities.*.website_url',
                ])
            ],
            'google_analytics_property_entities.*.account_name' => [
                implode(',', [
                    'required_with:google_analytics_property_entities.*.account_id',
                    'google_analytics_property_entities.*.property_id',
                    'google_analytics_property_entities.*.property_name',
                    'google_analytics_property_entities.*.website_url',
                ])
            ],
            'google_analytics_property_entities.*.property_id' => [
                implode(',', [
                    'required_with:google_analytics_property_entities.*.account_id',
                    'google_analytics_property_entities.*.account_name',
                    'google_analytics_property_entities.*.property_name',
                    'google_analytics_property_entities.*.website_url',
                ])
            ],
            'google_analytics_property_entities.*.property_name' => [
                implode(',', [
                    'required_with:google_analytics_property_entities.*.account_id',
                    'google_analytics_property_entities.*.account_name',
                    'google_analytics_property_entities.*.property_id',
                    'google_analytics_property_entities.*.website_url',
                ])
            ],
            'google_analytics_property_entities.*.website_url' => [
                implode(',', [
                    'required_with:google_analytics_property_entities.*.account_id',
                    'google_analytics_property_entities.*.account_name',
                    'google_analytics_property_entities.*.property_id',
                    'google_analytics_property_entities.*.property_name',
                ])
            ],
        ];
    }
}
