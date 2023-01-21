<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FooterRequest extends FormRequest
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
            'name0' => 'required|string|max:10',
            'link0' => 'required|string|max:255',
            'name1' => 'required|string|max:10',
            'link1' => 'required|string|max:255',
            'name2' => 'required|string|max:10',
            'link2' => 'required|string|max:255',
            'name3' => 'required|string|max:10',
            'link3' => 'required|string|max:255',
            'name4' => 'required|string|max:10',
            'link4' => 'required|string|max:255',
            'name5' => 'required|string|max:10',
            'link5' => 'required|string|max:255',
            'name6' => 'required|string|max:10',
            'link6' => 'required|string|max:255',
            'name7' => 'required|string|max:10',
            'link7' => 'required|string|max:255',
            'name8' => 'required|string|max:10',
            'link8' => 'required|string|max:255',

        ];
    }
    public function messages()
    {
        return [
        'name0.required' => 'リンク名を入力してください',
        'name0.string' => '文字形式で入力してください',
        'name0.max' => '表示する文章は、10文字以内で入力してください',
        'link0.required' => 'リンクアドレスを入力してください',
        'link0.string' => '文字形式で入力してください',
        'link0.max' => '表示するアドレスは、255文字以内で入力してください',

        'name1.required' => 'リンク名を入力してください',
        'name1.string' => '文字形式で入力してください',
        'name1.max' => '表示する文章は、10文字以内で入力してください',
        'link1.required' => 'リンクアドレスを入力してください',
        'link1.string' => '文字形式で入力してください',
        'link1.max' => '表示するアドレスは、255文字以内で入力してください',

        'name2.required' => 'リンク名を入力してください',
        'name2.string' => '文字形式で入力してください',
        'name2.max' => '表示する文章は、10文字以内で入力してください',
        'link2.required' => 'リンクアドレスを入力してください',
        'link2.string' => '文字形式で入力してください',
        'link2.max' => '表示するアドレスは、255文字以内で入力してください',

        'name3.required' => 'リンク名を入力してください',
        'name3.string' => '文字形式で入力してください',
        'name3.max' => '表示する文章は、10文字以内で入力してください',
        'link3.required' => 'リンクアドレスを入力してください',
        'link3.string' => '文字形式で入力してください',
        'link3.max' => '表示するアドレスは、255文字以内で入力してください',

        'name4.required' => 'リンク名を入力してください',
        'name4.string' => '文字形式で入力してください',
        'name4.max' => '表示する文章は、10文字以内で入力してください',
        'link4.required' => 'リンクアドレスを入力してください',
        'link4.string' => '文字形式で入力してください',
        'link4.max' => '表示するアドレスは、255文字以内で入力してください',

        'name5.required' => 'リンク名を入力してください',
        'name5.string' => '文字形式で入力してください',
        'name5.max' => '表示する文章は、10文字以内で入力してください',
        'link5.required' => 'リンクアドレスを入力してください',
        'link5.string' => '文字形式で入力してください',
        'link5.max' => '表示するアドレスは、255文字以内で入力してください',

        'name6.required' => 'リンク名を入力してください',
        'name6.string' => '文字形式で入力してください',
        'name6.max' => '表示する文章は、10文字以内で入力してください',
        'link6.required' => 'リンクアドレスを入力してください',
        'link6.string' => '文字形式で入力してください',
        'link6.max' => '表示するアドレスは、255文字以内で入力してください',

        'name7.required' => 'リンク名を入力してください',
        'name7.string' => '文字形式で入力してください',
        'name7.max' => '表示する文章は、10文字以内で入力してください',
        'link7.required' => 'リンクアドレスを入力してください',
        'link7.string' => '文字形式で入力してください',
        'link7.max' => '表示するアドレスは、255文字以内で入力してください',

        'name8.required' => 'リンク名を入力してください',
        'name8.string' => '文字形式で入力してください',
        'name8.max' => '表示する文章は、10文字以内で入力してください',
        'link8.required' => 'リンクアドレスを入力してください',
        'link8.string' => '文字形式で入力してください',
        'link8.max' => '表示するアドレスは、255文字以内で入力してください',

    ];
    }
}
