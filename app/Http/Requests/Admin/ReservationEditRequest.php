<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReservationEditRequest extends FormRequest
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

    public function rules()
    {
        return [
            'date' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
        'date.required' => '日付けを入力してください',
        'date.string' => '文字形式で入力してください',
        ];
    }
}

