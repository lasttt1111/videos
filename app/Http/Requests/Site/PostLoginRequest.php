<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PostLoginRequest extends FormRequest
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
            'username' => 'required|string|between:6,150',
            'password' => 'required|string|between:6,150',
        ];
    }

    public function messages()
    {
        return [
            'username.*' => __('Tên đăng nhập không hợp lệ'),
            'password.*' => __('Mật khẩu không hợp lệ'),
        ];
    }
}
