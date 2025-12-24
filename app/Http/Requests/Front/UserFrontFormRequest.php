<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class UserFrontFormRequest extends Request
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
            'first_name' => 'required|max:80',
            'middle_name' => 'nullable|max:80',
            'last_name' => 'nullable|max:80',
            'date_of_birth' => 'nullable|date',

            'nationality_id' => 'required',
            'gender_id' => 'required',
            'marital_status_id' => 'nullable',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'mobile_num' => 'required|max:22',

            'industry_id' => 'required',
            'functional_area_id' => 'required',
            'functional_area' => 'required_if:functional_area_id,custom|max:255',
            'salary_currency' => 'required',
            'current_salary' => 'required_with:expected_salary',
            'expected_salary' => 'required_with:current_salary|gt:current_salary',
            'notice_period' => 'required|integer',

            'street_address' => 'nullable|max:230',
            'image' => 'nullable|image|max:5120|mimes:jpeg,png,jpg,gif',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => __('First Name is required'),
            'first_name.max' => __('First Name should not exceed 80 characters'),
            'middle_name.max' => __('Middle Name should not exceed 80 characters'),
            'middle_name.nullable' => __('Middle Name is optional'),
            'last_name.max' => __('Last Name should not exceed 80 characters'),
            'last_name.nullable' => __('Last Name is optional'),
            'date_of_birth.date' => __('Please enter a valid Date of Birth'),

            'nationality_id.required' => __('Please select nationality'),
            'gender_id.required' => __('Please select gender'),
            'marital_status_id.nullable' => __('Marital Status is optional'),
            'country_id.required' => __('Please select country'),
            'state_id.required' => __('Please select state'),
            'city_id.required' => __('Please select city'),
            'mobile_num.required' => __('Please enter mobile number'),
            'mobile_num.max' => __('Mobile number should not exceed 22 characters'),

            'industry_id.required' => __('Please select industry'),
            'functional_area_id.required' => __('Please select functional area'),
            'functional_area.required_if' => __('Please enter custom functional area'),
            'functional_area.max' => __('Custom functional area should not exceed 255 characters'),
            'salary_currency.required' => __('Please select salary currency'),
            'current_salary.required_with' => __('Current salary is required when expected salary is provided'),
            'expected_salary.required_with' => __('Expected salary is required when current salary is provided'),
            'expected_salary.gt' => __('Expected salary must be greater than current salary'),
            'notice_period.required' => __('Please select a notice period'),
            'street_address.max' => __('Street Address should not exceed 230 characters'),

            'image.image' => __('Only images (jpeg, png, jpg, gif) can be uploaded'),
            'image.max' => __('Image size should not exceed 5MB'),
            'image.mimes' => __('Image must be in one of the following formats: jpeg, png, jpg, or gif'),
        ];
    }
}
