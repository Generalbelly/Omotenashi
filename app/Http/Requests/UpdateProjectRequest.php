<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends AddProjectRequest
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
        $userKey = $this->user()->key;
        return array_merge(parent::rules(), [
            'domain' => [
                'required',
                'domain',
                'max:100',
                Rule::unique('projects')->where(function ($query) use ($userKey) {
                    return $query->where('user_id', $userKey);
                })->ignore($this->request->get('id'))
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
        ]);
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'domain.unique' => 'The domain has already been used by your another project',
        ];
    }
}
