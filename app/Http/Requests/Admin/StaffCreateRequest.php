<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StaffCreateRequest extends FormRequest
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
        ];
    }
    public function messages()
    {
        return [
        'name.required' => 'スタッフ名を入力してください',
        'name.string' => '文字形式で入力してください',
        'name.max' => 'スタッフ名は、30文字以内で入力してください',
        ];
    }
}
