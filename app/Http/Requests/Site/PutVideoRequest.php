<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PutVideoRequest extends FormRequest
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
            'description' => 'sometimes|string|max:1000|nullable',
            'category' => 'required|string|model_exists:\App\Models\Category,id',
            'tags' => 'array|nullable',
            'image' => 'sometimes|image|nullable',
            'label' => 'required|max:5',
            'privacy' => 'required|in:0,1,2',
            'price' => 'required|integer|between:0,100000000',
            'password' => 'sometimes|string|nullable',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Vui lòng nhập tựa đề'),
            'title.string' => __('Tựa đề không hợp lệ'),
            'title.between' => __('Tựa đề từ :min đến :max', ['min' => 6, 'max' => 150]),

            'description.string' => __('Mô tả không hợp lệ'),
            'description.max' => __('Mô tả tối đa :max kí tự', ['max' => 1000]),

            'category.*' => __('Danh mục không hợp lệ'),

            'tags.*' => __('Thẻ không hợp lệ'),

            'image.*' => __('Ảnh không hợp lệ'),

            'label.required' => __('Vui lòng nhập nhãn'),
            'label.max' => __('Nhãn tối đa :max kí tự', ['max' => 5]),

            'privacy.required' => __('Vui lòng chọn quyền riêng tư'),
            'privacy.in' => __('Quyền riêng tư không hợp lệ'),

            'price.*' => __('Số tiền từ :min đến :max', ['min' => 0, 'max' => 100000000]),

            'password.string' => __('Mật khẩu không hợp lệ'),

            'g-recaptcha-response.*' => __('Xác thực không chính xác')
        ];
    }
}
