<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class CompanyFrontFormRequest extends Request
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
                    "name" => "required|max:150",
                    "ceo" => "required|max:60",
                    "industry_id" => "required",
                    "ownership_type_id" => "nullable",
                    "description" => "required",
                    "location" => "required|max:150",
                    'website' => ['required', 'max:150', 'regex:/^www\.[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/'],
                    //"map" => "required",
                    "no_of_offices" => "required|max:11",
                    "no_of_employees" => "required|max:15",
                    "established_in" => "required|max:12",

                    "phone" => "required|max:30",
                    "logo" => 'image|max:5120|mimes:jpeg,png,jpg,gif',
                    "country_id" => "required",
                    "state_id" => "required",
                    "city_id" => "required",
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => __('Name is required'),
            'ceo.required' => __('CEO name is required'),
            'industry_id.required' => __('Please select Industry'),
            'description.required' => __('Description required'),
            'location.required' => __('Location required'),
            'map.required' => __('Google Map required'),
            'no_of_offices.required' => __('Number of offices required'),
            'website.required' => __('Website required'),
            'website.regex' => 'The website must be in the format www.example.com',
            'no_of_employees.required' => __('Number of employees required'),
            'established_in.required' => __('Established in year required'),

            'phone.required' => __('Phone number required'),
            'logo.image' => __('Only Images can be used as logo'),
            'country_id.required' => __('Please select country'),
            'state_id.required' => __('Please select state'),
            'city_id.required' => __('Please select city'),
        ];
    }

}
