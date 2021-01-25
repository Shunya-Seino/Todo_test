<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
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
            'name' => 'required|string||max:32',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:32|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        return [
            'name.not_empty' => ':attribute を入力してください。',
            'email.not_empty' => ':attribute を入力してください。',
            'password.not_empty' => ':attribute を入力してください。',
        ];
    }
}
