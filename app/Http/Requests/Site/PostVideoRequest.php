<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PostVideoRequest extends FormRequest
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
            'video' => 'required|mimes:mp4,mov,ogg,qt | max:50000',
            'category' => 'required|model_exists:\App\Models\Category,id',
            'tags' => 'array|nullable',
            'image' => 'required|image',
            'label' => 'required|max:5',
            // 'language' => 'required|string',
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

            'video.max' => __('Video quá dung lượng', ['max' => 20000]),
            'video.*' => __('Video không hợp lệ'),
            'video.required' => __('Vui lòng chọn video'),

            'category.*' => __('Danh mục không hợp lệ'),

            'tags.*' => __('Thẻ không hợp lệ'),

            'image.required' => __('Vui lòng chọn hình ảnh'),
            'image.image' => __('Ảnh không hợp lệ'),

            'label.required' => __('Vui lòng nhập nhãn'),
            'label.max' => __('Nhãn tối đa :max kí tự', ['max' => 5]),

            // 'language.required' => __('Vui lòng chọn ngôn ngữ'),
            // 'language.*' => __('Ngôn ngữ không hợp lệ'),

            'privacy.required' => __('Vui lòng chọn quyền riêng tư'),
            'privacy.*' => __('Quyền riêng tư không hợp lệ'),

            'price.*' => __('Số tiền từ :min đến :max', ['min' => 0, 'max' => 100000000]),

            'password.string' => __('Mật khẩu không hợp lệ'),

            'g-recaptcha-response.*' => __('Xác thực không chính xác')
        ];
    }
}
