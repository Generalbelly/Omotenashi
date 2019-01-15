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
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'url' => 'required|url',
            'steps' => 'array',
            'steps.*.element' => 'required_with:steps.*.popover',
            'steps.*.popover' => 'required_with_all:steps.*.element',
            'steps.*.popover.content' => 'required_with:steps.*.popover',
        ];
    }
}
