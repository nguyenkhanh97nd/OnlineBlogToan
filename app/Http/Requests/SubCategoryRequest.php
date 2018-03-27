<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'txtSlug'=>'required|unique:sub_categories,slug',
            'numParent'=>'required',
            'txtDescription'=>'required'
        ];
    }
    public function messages(){
        return [
            'txtCateName.required'=>'Input name sub category',
            'txtSlug.required'=>'Input slug sub category',
            'txtSlug.unique'=>'The slug sub category is exist. Chose the other slug sub category',
            'numParent.required'=>'Chose category',
            'txtDescription.required'=>'Input descriptions sub category'
        ];
    }
}
