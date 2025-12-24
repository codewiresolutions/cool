<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class ApplyJobFormRequest extends Request
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
                return [
                    "cv_id" => "required",
                    "current_salary" => "nullable|max:11",
                    "expected_salary" => "nullable|max:11",
                    "salary_currency" => "nullable|max:5",
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'cv_id.required' => __('Please select CV'),
            'current_salary.max' => __('Please enter a valid current salary'),
            'expected_salary.max' => __('Please enter a valid expected salary'),
            'salary_currency.max' => __('Please enter a valid salary currency'),
        ];
    }

}
