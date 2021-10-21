<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Encryption extends FormRequest
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
            'key' => 'required',
            'message' => 'required',
            'p' => 'required',
            'q' => 'required',
            'k' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'key.required' => 'Key is required',
            'message.required' => 'Message is required',
            'p.required' => 'p is required',
            'q.required' => 'q is required',
            'k.required' => 'k is required'
        ];
    }
}
