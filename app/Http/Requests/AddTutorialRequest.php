<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTutorialRequest extends FormRequest
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
            'domain' => 'required',
            'name' => 'required|max:100',
            'description' => 'required|max:100',
            'path' => 'required',
            'steps' => 'array',
            'steps.*.element' => 'required_if:steps',
            'steps.*.popover' => 'required_if:steps',
            'steps.*.popover.*.content' => 'required_if:steps',
        ];
    }
}
