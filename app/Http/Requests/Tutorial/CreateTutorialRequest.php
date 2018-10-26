<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTutorialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'description' => 'required|max:100',
            'steps' => 'array',
            'domain' => 'required',
            'path' => 'required',

            'steps.*.element' => 'required_if:steps',
            'steps.*.popover' => 'required_if:steps',
            'steps.*.popover.*.content' => 'required_if:steps',
        ];
    }
}
