<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTodo extends FormRequest
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
            'title' => 'required|string|max:32',
            'detail' => 'required|string|max:1024',
            'start_date' => 'required|date_format:Y/m/d',
            'due_date' => 
            [
                'required',
                'date_format:Y/m/d',
                function($attribute, $value, $fail){
                    $start_date = $this->start_date;
                    $due_date = $this->due_date;
                    if ($due_date < $start_date) {
                      $fail('期限日は開始日より後にしてください。');
                    }
                }
            ],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル名',
            'detail' => '詳細内容',
            'start_date' => '開始日',
            'due_date' => '期限日',
        ];
    }
}
