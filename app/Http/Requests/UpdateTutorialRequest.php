<?php

namespace App\Http\Requests;

class UpdateTutorialRequest extends AddTutorialRequest
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
        return array_merge(parent::rules(), [
            'steps.*.element' => 'required_with:steps.*.popover',
            'steps.*.popover' => 'required_with_all:steps.*.element',
            'steps.*.popover.content' => 'required_with:steps.*.popover',
            'project_id' => 'nullable',
        ]);
    }
}
