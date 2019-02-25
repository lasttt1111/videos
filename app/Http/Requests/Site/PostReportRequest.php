<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PostReportRequest extends FormRequest
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
            'message' => 'required|string|max:1000',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages(){
        return [
            'message.required' => __('Vui lòng nhập nội dung'),
            'message.*' => __('Nội dung tối đa :max kí tự', ['max' => 1000]),

            'g-recaptcha-response.*' => __('Xác thực không hợp lệ'),
        ];
    }
}
