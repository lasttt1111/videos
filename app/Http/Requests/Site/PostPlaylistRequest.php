<?php

namespace App\Http\Requests\Site;

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
            'title' => 'required|string|between:6,150',
            'image' => 'required|image',
            'privacy' => 'required|in:0,1,2',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Vui lòng nhập tựa đề'),
            'title.*' => __('Tựa đề từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),

            'image.*' => __('Ảnh không hợp lệ'),

            'privacy.*' => __('Quyền không hợp lệ'),

            'g-recaptcha-response' => __('Mã xác thực không hợp lệ'),
        ];
    }
}
