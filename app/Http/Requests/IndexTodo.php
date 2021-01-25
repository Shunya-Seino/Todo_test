<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Model\Todo;

class IndexTodo extends FormRequest
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
            'title' => 'max:32',
            'detail' => 'max:1024',
            'start_date_from' => 'nullable|date_format:Y/m/d',
            'start_date_to' => 
            [
                'nullable',
                'date_format:Y/m/d',
                function($attribute, $value, $fail){
                    $input_start_date_from = $this->start_date_from;
                    $input_start_date_to = $this->start_date_to;
                    if ($input_start_date_to < $input_start_date_from) {
                      $fail('開始日：検索終了日時は検索開始日時より後にしてください。');
                    }
                }
            ],
            'due_date_from' => 
            [
                'nullable',
                'date_format:Y/m/d',
                function($attribute, $value, $fail){
                    $input_due_date_from = $this->due_date_from;
                    $input_start_date_to = $this->start_date_to;
                    if ($input_due_date_from < $input_start_date_to) {
                      $fail('期限日：期限日は開始日より後にしてください。');
                    }
                }
            ],
            'due_date_to' => 
            [
                'nullable',
                'date_format:Y/m/d',
                function($attribute, $value, $fail){
                    $input_due_date_from = $this->due_date_from;
                    $input_due_date_to = $this->due_date_to;
                    if ($input_due_date_to < $input_due_date_from) {
                      $fail('期限日：検索終了日時は検索開始日時より後にしてください。');
                    }
                }
            
            ],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'detail' => '詳細内容',
            'start_date_from' => '開始日：検索範囲開始日付',
            'start_date_to' => '開始日：検索範囲終了日付',
            'due_date_from' => '期限日：検索範囲開始日付',
            'due_date_to' => '期限日：検索範囲終了日付',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
