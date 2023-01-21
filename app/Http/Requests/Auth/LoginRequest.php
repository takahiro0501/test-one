<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8','max:255'],
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.string' => '文字形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.max' => 'パスワードは255文字以内で入力してください',
            'password.min' => 'パスワードは８文字以上で入力してください',
            'password.string' => '文字形式で入力してください',
        ];
    }
}
