<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'txtCateName'=>'required',
            'txtSlug'=>'required|unique:categories,slug',
            'txtDescription'=>'required'
        ];
    }
    public function messages(){
        return [
            'txtCateName.required'=>'Input name category',
            'txtSlug.required'=>'Input slug category',
            'txtSlug.unique'=>'The slug category is exist. Chose other slug category',
            'txtDescription.required'=>'Input descriptions category'
        ];
    }
}
