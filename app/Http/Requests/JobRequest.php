<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'desc' => 'required',
            'position' => 'required',
            'job_address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '招聘标题不能为空。',
        ];
    }
}
