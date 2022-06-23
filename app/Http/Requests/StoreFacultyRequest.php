<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacultyRequest extends FormRequest
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
            'name' => 'required|unique:faculties',
        ];

        if (!empty(request()->route('faculty'))){
            $data['name'] = 'required|unique:faculties';
        }

        return $data;
    }
    public function messages()
    {
        return [
            'name.required' => 'Enter faculty name is required',
            'name.unique' => 'This faculty was in existence. ',
        ];
    }
}
