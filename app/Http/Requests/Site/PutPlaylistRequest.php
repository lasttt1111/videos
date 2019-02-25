<?php

namespace App\Http\Requests\Site;

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
            'privacy' => 'required|in:0,1,2',
            'title' => 'required|string|between:6,150',
            'image' => 'image|nullable',
            'video' => ['nullable', 'string', 'regex:/^((\\d+),)*(\\d+)$/'],
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'privacy.*' => __('Quyền riêng tư không hợp lệ'),
            'title.*' => __('Tên từ :min đến :max kí tự', ['min' => 6, 'max' => 150]),
            'image.*' => __('Ảnh không hợp lệ'),
            'video.*' => __('Có lỗi xảy ra'),
            'g-recaptcha-response.*' => __('Mã xác thực không hợp lệ'),
        ];
    }
}
