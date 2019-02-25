<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PutUserRequest extends FormRequest
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
            'name' => 'required|string|between:6,150',
            'password' => 'nullable|string|between:6,150',
            'permission' => 'nullable|in:1,2,3',
            'avatar' => 'image|nullable',
            'cover' => 'image|nullable',
        ];
    }

    public function messages(){
        return [
            'password.required' => __('Vui lòng nhập mật khẩu'),
            'password.*' => __('mật khẩu từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'alias.required' => __('Vui lòng nhập định danh'),
            'alias.*' => __('Định danh từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'permission.*' => __('Quyền không hợp lệ'),
            'avatar.*' => __('Ảnh không hợp lệ'),
            'cover.*' => __('Ảnh bìa không hợp lệ'),
        ];
    }
}
