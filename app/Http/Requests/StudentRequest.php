<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $data = [
            'name' => 'required|max:55',
            'phone' => 'required|numeric|min:15',
            // 'phone' => [
            //     'required',
            //     'numeric',
            //     Rule::unique('students')->ignore($this->id)
            // ],
            'gender' => 'required',
            'email' => 'required|email|unique:students,email,'.$this->id,
            'birthday' => 'required|date|before:01/01/2100|after:01/01/1900',
            'faculty_id' => 'required',
        ];

        if (!empty(request()->route('student'))){
            $data['email'] = 'required|email|unique:students,email,' . request()->route('student');
        }

        return $data;
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email was in existence.',
            'phone.unique' => 'This phone was in existence.',
            'faculty_id.required' => 'Choose faculty'
        ];
    }
}
