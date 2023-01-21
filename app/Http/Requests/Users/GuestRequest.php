<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
            'phone.required' => '電話番号を入力してください',
            'phone.string' => '文字形式で入力してください',
            'phone.max' => '電話番号はハイフン無し12桁以内で入力して下さい',
        ];
    }
}
