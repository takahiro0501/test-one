<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ];
    }

    public function messages()
    {
        return [
        'email.required' => 'メールアドレスを入力してください',
        'email.string' => '文字形式で入力してください',
        'email.email' => 'メールアドレスの形式で入力してください',
        'email.exists' => 'メールアドレスが登録されていません',
        ];
    }
}
