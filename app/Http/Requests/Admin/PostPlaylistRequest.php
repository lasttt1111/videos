<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostPlaylistRequest extends FormRequest
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
            'alias' => 'string|between:6,150|nullable',
            'privacy' => 'required|in:0,1,2',
            'title' => 'required|string|between:6,150',
            'image' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'alias.*' => __('Định danh từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'privacy.*' => __('Quyền riêng tư không hợp lệ'),
            'title.*' => __('Tên từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'image.*' => __('Ảnh không hợp lệ'),
        ];
    }
}
