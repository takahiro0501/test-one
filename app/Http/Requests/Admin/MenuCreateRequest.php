<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuCreateRequest extends FormRequest
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
            'name' => 'required|string|max:30',
            'time' => ['required', 'string','max:9'],
            'money' => ['required', 'string','max:9'],
            'overview' => 'required|string|max:300',
        ];
    }

    public function messages()
    {
        return [
        'name.required' => '施術名を入力してください',
        'name.string' => '文字形式で入力してください',
        'name.max' => '施術名は、30文字以内で入力してください',
        'time.required' => '施術時間を入力してください',
        'time.string' => '文字形式で入力してください',
        'time.max' => '入力できる数値範囲を超えています',        
        'money.required' => '金額を入力してください',
        'money.string' => '文字形式で入力してください',
        'money.max' => '入力できる数値範囲を超えています',
        'overview.required' => '内容紹介文を入力してください',
        'overview.string' => '文字形式で入力してください',
        'overview.max' => '内容紹介文は、300文字以内で入力してください',
        ];
    }
}
