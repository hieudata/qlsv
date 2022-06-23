<?php

namespace App\Http\Requests;

use App\Models\Student;
use Cviebrock\EloquentSluggable\Services\SlugService;
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
        $data = [
            'name' => 'required|max:50',
            'phone' => 'required|unique:students,phone',
            'gender' => 'required',
            'email' => 'required|email|unique:students,email',
            'birthday' => 'required',
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
        ];
    }
}
