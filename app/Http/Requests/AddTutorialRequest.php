<?php

namespace App\Http\Requests;

use App\Domains\Entities\TutorialEntity;
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
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'path' => [
                'required',
                function ($attribute, $value, $fail) {
                    $valid = true;
                    if (
                        array_key_exists('deepness', $value) &&
                        array_key_exists('value', $value) &&
                        array_key_exists('regex', $value)
                    ) {
                        if ($value['regex'] == true) {
                            try {
                                $regex = TutorialEntity::generateRegex($value['value']);
                                if (preg_match($regex, null) === false) {
                                    $valid = false;
                                } else {
                                    $valid = true;
                                }
                            } catch (\Exception $e) {
                                $valid = false;
                                \Log::error($e->getMessage());
                            }
                        }
                    } else {
                        $valid = false;
                    }
                    if (!$valid) {
                        $fail($attribute.' is invalid.');
                    }
                },
            ],
            'steps' => 'array',
            'project_id' => 'required|uuid',
        ];
    }
}
