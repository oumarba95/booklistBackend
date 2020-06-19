<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'name'=>['required'],
            'email'=>'bail|required|email|unique:users',
            'password'=>['bail','required','regex:/^((?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9]{8,14})|[a-zA-Z0-9]{15,}$/','confirmed']
        ];
    }
}
