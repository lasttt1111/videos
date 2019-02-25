<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostTagRequest extends FormRequest
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
            'alias' => 'string|max:150|nullable',
            'title' => 'required|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'alias.*' => __('Định danh tối đa :max kí tự', ['max' => 150]),
            'title.required' => __('Vui lòng nhập tên'),
            'title.*' => __('Tên tối đa :max kí tự', ['min' => 6, 'max' => 150]),
        ];
    }
}
