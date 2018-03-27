<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditorBQuestionRequest extends FormRequest
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
            'id_post'=>'required',
            'quess'=>'required|min:1|max:50',
            'test'=>'required',
            'result'=>'required',
        ];
    }
    public function messages(){
        return [
            'id_post.required'=>'Chose the post',
            'quess.required'=>'Input number questions',
            'quess.min'=>'Number questions wrong',
            'quess.max'=>'Number questions wron',
            'test.required'=>'Input content Questions',
            'result.required'=>'Input result Questions',
        ];
    }
}
