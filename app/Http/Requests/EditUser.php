<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUser extends FormRequest
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
        //dd ($this->id);
        //ignore($this->hoge)のhogeは、取得するレコードの主キー。どこにもそんな説明ないけど。
        return [
            'name' => 'required|string|max:32',
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                Rule::unique('users')->ignore($this->id)],
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
