<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'phone' => ['required', 'string','max:12'],
            'email' => ['max:250'],
            'firstnamekana' => ['max:20'],
            'lastnamekana' => ['max:20'],
            'postcode' => ['max:7'],
            'city' => ['max:8'],
            'address' => ['max:180'],
            'cellphone' => ['max:12'],
            'password' => ['max:100'],
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
        'firstnamekana.max' => '20文字以内で入力してください',
        'lastnamekana.max' => '20文字以内で入力してください',
        'postcode.max' => '7文字以内で入力してください',
        'city.max' => '8文字以内で入力してください',
        'address.max' => '180文字以内で入力してください',
        'cellphone.max' => 'ハイフン無し12文字以内で入力してください',
        'email.max' => '250文字以内で入力してください',
        'phone.required' => '電話番号を入力してください',
        'phone.string' => '文字形式で入力してください',
        'phone.max' => '電話番号はハイフン無し12桁以内で入力して下さい',
        'password.max' => 'パスワードは100文字以内で入力してください',
        ];
    }
}
