<?php

namespace App\Http\Requests;

class ProfileProjectFormRequest extends Request
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
        switch ($this->method()) {
            case 'PUT':
            case 'POST':
            {
                $id = (int)$this->input('id', 0);
                return [
                    "name" => "required",
                    "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                    "url" => "nullable",
                    "tech" => "nullable",
                    "date_start" => "required",
                    "date_end" => "required_if:is_on_going,0",
                    "is_on_going" => "required",
                    "description" => "required",
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter project name.',
            'image.required' => 'Only images can be uploaded.',
            'url.required' => 'Please enter project URL.',
            'date_start.required' => 'Please set start date.',
            'date_end.required_if' => 'Please set end date.',
            'is_on_going.required' => 'Is this project ongoing?',
            'description.required' => 'Please enter project description.',
        ];
    }

}
