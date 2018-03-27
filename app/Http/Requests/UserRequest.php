<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'txtUser'=>'required|unique:users,username',
            'txtPass'=>'required',
            'txtRePass'=>'required|same:txtPass',
            'txtEmail'=>'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/|unique:users,email'
        ];
    }
    public function messages(){
        return [
            'txtUser.required'=>'Input username',
            'txtUser.unique'=>'Username is exist',
            'txtPass.required'=>'Input password',
            'txtRePass.required'=>'Input confirm password',
            'txtRePass.same'=>'Wrong confirm password',
            'txtEmail.required'=>'Input email',
            'txtEmail.regex'=>'Wrong email',
            'txtEmail.unique'=>'Email is exist'
        ];
    }
}
