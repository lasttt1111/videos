<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostLanguageRequest extends FormRequest
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
            'code' => 'required|string|max:10|model_unique:\App\Models\Language,id',
            'name' => 'required|string|max:150',
            'language' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => __('Vui lòng nhập mã'),
            'code.model_unique' => __('Mã đã trùng'),
            'code.*' => __('Mã tối đa :max kí tự', ['max' => 10]),

            'name.required' => __('Vui lòng nhập tên'),
            'name.*' => __('Tên tối đa :max kí tự', ['max' => 150]),

            'language.*' => __('Ngôn ngữ không hợp lệ'),
        ];
    }
}
