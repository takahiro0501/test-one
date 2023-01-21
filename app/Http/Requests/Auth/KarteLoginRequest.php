<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class KarteLoginRequest extends FormRequest
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
            'karte_no' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
        ];
    }
    public function messages()
    {
        return [
        'karte_no.required' => 'カルテ番号を入力してください',
        'karte_no.string' => '文字形式で入力してください',
        'firstname.required' => '氏名（名）を入力してください',
        'firstname.string' => '文字形式で入力してください',
        'lastname.required' => '氏名（姓）を入力してください',
        'lastname.string' => '文字形式で入力してください',
        ];
    }
}
