<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class PasswordUpdateRequest extends FormRequest
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
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8','max:255']
        ];
    }
    public function messages()
    {
        return [
        'token.required' => 'トークン情報がありません。',
        'email.required' => 'メールアドレスがありません。',
        'email.email' => 'メールアドレスの形式で入力してください',
        'password.required' => 'パスワードを入力してください。',
        'password.confirmed' => 'パスワードが一致しません。',
        'password.min' => '8文字以上で入力してください',
        'password.max' => '255文字以内で入力してください',
    ];
    }
}
