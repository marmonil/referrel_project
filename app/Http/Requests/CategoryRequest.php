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
        return  [
            'category_name' => 'required',
            'category_image' => 'image',
            'category_image' => 'image|max:4024',
        ];
    }
    public function messages()

    {
        return  [
            'category_name.required' => 'category name deoya lagbe',
            'category_image.image' => 'image chara onno kicho deoya jabe na',

        ];
    }
}
