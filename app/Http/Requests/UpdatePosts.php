<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePosts extends FormRequest
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
            // dinh nghia cac luat rang buoc du lieu tu form gui len
            'titlePost' => 'required|max:100',
            'sapoPost' => 'required|max:180',
            'language' => 'required|numeric',
            'categories' => 'required|numeric',
            'contentPost' => 'required',
        ];
    }

        // message errors
    public function messages()
    {
        return [
            'titlePost.required' => ':attribute khong duoc trong',
            'titlePost.max' => ':attribute khong duoc lon :max ki tu',
            'sapoPost.required' => ':attribute khong duoc trong',
            'sapoPost.max' => ':attribute khong duoc lon :max ki tu',
            'language.required' => ':attribute khong duoc trong',
            'language.numeric' => 'vui long chon dung ngon ngu',
            'categories.numeric' => 'Category khong dung',
            'categories.required' => 'Category khong duoc de trong',
            'contentPost.required' => ':attribute khong duoc trong',
        ];
    }
}
