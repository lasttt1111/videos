<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PostUserRequest extends FormRequest
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
            'name' => 'required|string|between:6,150',
            'avatar' => 'image|nullable',
            'cover' => 'image|nullable',
            'password' => 'nullable|confirmed|string|between:6,150',
            'password_confirmation',
        ];
    }

    public function messages()
    {
        return [
            'name.*' => __('Tên từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'avatar.*' => __('Ảnh đại diện không hợp lệ'),
            'cover.*' => __('Ảnh bìa không hợp lệ'),
            'password.confirmed' => __('Mật khẩu xác nhận không chính xác'),
            'password.*' => __('Mật khẩu từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
        ];
    }
}
