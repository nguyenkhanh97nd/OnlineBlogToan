<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditorPostRequest extends FormRequest
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
            'category'=>'required',
            'subcategory'=>'required',
            'txtName'=>'required|unique:posts,name',
            'txtSlug'=>'required|unique:posts,slug',
            'txtBrief'=>'required',
            'txtContent'=>'required',
            'image'=>'required|image',
            'time_start'=>'required',
            'time_do'=>'required'
        ];
    }
    public function messages(){
        return [
            'category.required'=>'Chose category',
            'subcategory.required'=>'Chose sub category',
            'txtName.required'=>'Input name post',
            'txtName.unique'=>'Name post is exist',
            'txtSlug.required'=>'Input slug post',
            'txtSlug.unique'=>'The slug post is exist. Chose the other slug post',
            'txtBrief.required'=>'Input brief post',
            'txtContent.required'=>'Input content post',
            'image.required'=>'Chose image',
            'image.image'=>'Not image',
            'time_start.required'=>'Input time start exam',
            'time_do.required'=>'Input time do exam'
        ];
    }
}
