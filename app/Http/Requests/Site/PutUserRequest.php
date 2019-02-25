<?php

namespace App\Http\Requests\Site;

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
            // 'name' => 'required|string|between:6,150',
            'password' => 'nullable|required|confirmed|string|between:6,150',
            'password_confirmation',
        ];
    }

    public function messages()
    {
        return [
            // 'name.*' => __('Tên từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'password.confirmed' => __('Mật khẩu xác nhận không chính xác'),
            'password.*' => __('Mật khẩu từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
        ];
    }
}
