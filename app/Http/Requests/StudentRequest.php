<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'required|max:50',
            'phone' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'faculty_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'email.unique' => 'This email was in existence. ',
        ];
    }
}
