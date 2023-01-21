<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisteRequest extends FormRequest
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
            'firstname' => ['required', 'string','max:20'],
            'lastname' => ['required', 'string','max:20'],
            'firstnamekana' => ['max:20'],
            'lastnamekana' => ['max:20'],
            'postcode' => ['max:7'],
            'city' => ['max:8'],
            'address' => ['max:180'],
            'phone' => ['max:12'],
            'email' => ['required', 'string', 'email','unique:users','max:250'],
            'tel' => ['required', 'string','max:12'],
            'password' => ['required', 'string', 'min:8','max:100'],
        ];
    }

    public function messages()
    {
        return [
        'firstname.required' => '名前（名）を入力してください',
        'firstname.string' => '文字形式で入力してください',
        'firstname.max' => '20文字以内で入力してください',
        'lastname.required' => '名前（姓）を入力してください',
        'lastname.string' => '文字形式で入力してください',
        'lastname.max' => '20文字以内で入力してください',
        'tel.required' => '電話番号を入力してください',
        'tel.string' => '文字形式で入力してください',
        'tel.max' => '電話番号はハイフン無し12桁以内で入力してください',
        'email.required' => 'メールアドレスを入力してください',
        'email.email' => 'メールアドレスの形式で入力してください',
        'email.string' => '文字形式で入力してください',
        'email.unique' => '既にメールアドレスが登録されています',
        'email.max' => 'Emailは、250字以内で入力してください',
        'password.required' => 'パスワードを入力してください',
        'password.min' => 'パスワードは８文字以上を入力してください',
        'password.max' => 'パスワードは100文字以内で入力してください',
        'password.string' => '文字形式で入力してください',
        'firstnamekana.max' => '20文字以内で入力してください',
        'lastnamekana.max' => '20文字以内で入力してください',
        'postcode.max' => 'ハイフン無し7文字以内で入力してください',
        'city.max' => '8文字以内で入力してください',
        'address.max' => '180文字以内で入力してください',
        'phone.max' => '12文字以内で入力してください',
        ];
    }
}
