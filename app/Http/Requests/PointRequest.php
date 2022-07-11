<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PointRequest extends FormRequest
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
            "point.*" => "required|numeric|min:0|max:10",
            "subject_id.*" => "required"
        ];
    }

    public function messages()
    {
        return [
            // 'point.*.required' => 'Enter point required',
            // 'point.*.max' => "Point nho hon 10"
        ];
    }
}
