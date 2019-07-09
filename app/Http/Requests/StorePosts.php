<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePosts extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // true de thuc hien validation data
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
            'avatarPost' => 'required|mimes:jpeg,bmp,png,jpg,gif',
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
            'avatarPost.required' => 'hay nhap anh dai dien cho bai viet',
            'avatarPost.mimes' => 'Dinh dang anh avatar bai viet khong dung - dinh dang anh phai thuoc jpeg,bmp,png,jpg,gif',
            'language.required' => ':attribute khong duoc trong',
            'language.numeric' => 'vui long chon dung ngon ngu',
            'categories.numeric' => 'Category khong dung',
            'categories.required' => 'Category khong duoc de trong',
            'contentPost.required' => ':attribute khong duoc trong',
        ];
    }
}
