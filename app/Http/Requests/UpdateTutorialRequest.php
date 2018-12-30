<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTutorialRequest extends FormRequest
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
            'id' => ['required', 'regex:/^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$/'],
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'steps' => 'array',
            'steps.*.element' => 'required_with:steps.*.popover',
            'steps.*.popover' => 'required_with_all:steps.*.element',
            'steps.*.popover.content' => 'required_with:steps.*.popover',
        ];
    }
}
