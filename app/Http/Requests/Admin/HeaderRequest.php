<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HeaderRequest extends FormRequest
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
            'sentence1' => 'required|string|max:30',
            'sentence2' => 'required|string|max:30',
            'file' => ['max:10240']
        ];
    }
    public function messages()
    {
        return [
        'sentence1.required' => '表示する文章を入力してください',
        'sentence1.string' => '文字形式で入力してください',
        'sentence1.max' => '表示する文章は、30文字以内で入力してください',
        'sentence2.required' => '表示する文章を入力してください',
        'sentence2.string' => '文字形式で入力してください',
        'sentence2.max' => '表示する文章は、30文字以内で入力してください',
        'file.max' => 'ファイルサイズ上限(10MB)を超えています',
        ];
    }
}
