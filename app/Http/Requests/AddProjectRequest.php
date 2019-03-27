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
        $userKey = $this->user()->key;
        return [
            'name' => 'required|max:100',
            'domain' => [
                'required',
                'domain',
                'max:100',
                Rule::unique('projects')->where(function ($query) use ($userKey) {
                    return $query->where('user_id', $userKey);
                })
            ],
            'protocol' => [
                'required',
                Rule::in(['http', 'https']),
                'max:20',
            ],
            'tutorial_settings' => [
                'required',
                function ($attribute, $value, $fail) {
                    $invalids = [];
                    foreach ($value as $k => $v) {
                        switch ($k) {
                            case 'distribution_ratio':
                                if (!in_array($v, ['random', 'even'])) {
                                    $invalids[] = $k;
                                }
                                break;
                            case 'only_once':
                                if (!in_array($v, ['true', 'false'])) {
                                    $invalids[] = $k;
                                }
                                break;
                            case 'only_once_duration':
                                if (!($v === 'forever' || is_numeric($v))) {
                                    $invalids[] = $k;
                                }
                                break;
                            default:
                                break;
                        }
                    }
                    if (count($invalids) > 0) {
                        $fail(sprintf(
                            "%s %s invalid.",
                            implode(',', $invalids),
                            count($invalids) > 1 ? 'are' : 'is'
                        ));
                    }
                },
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
