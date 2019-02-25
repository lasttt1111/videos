<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PostRegisterRequest extends FormRequest
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
            'email' => 'required|email|model_unique:\App\Models\User,email',
            'password' => 'required|confirmed|string|between:6,150',
            'password_confirmation',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Vui lòng nhập tên'),
            'email.required' => __('Vui lòng nhập email'),
            'email.model_unique' => __('Email đã tồn tại'),
            'email.*' => __('Email không hợp lệ'),
            'name.*' => __('Tên đề từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'password.confirmed' => __('Mật khẩu xác nhận không chính xác'),
            'password.*' => __('Mật khẩu từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'g-recaptcha-response.*' => __('Xác thực không chính xác')
        ];
    }
}
