<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PutPlaylistRequest extends FormRequest
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
            'alias' => 'required|string|between:6,150',
            'privacy' => 'required|in:0,1,2',
            'title' => 'required|string|between:6,150',
            'image' => 'image|nullable',
        ];
    }

    public function messages()
    {
        return [
            'alias.required' => __('Vui lòng nhập định danh'),
            'alias.*' => __('Định danh từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'privacy.*' => __('Quyền riêng tư không hợp lệ'),
            'title.*' => __('Tên từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'image.*' => __('Ảnh không hợp lệ'),
        ];
    }
}
