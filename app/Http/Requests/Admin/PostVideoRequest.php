<?php

namespace App\Http\Requests\Admin;

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
            'user_alias' => 'string|between:6,150|nullable',
            'title' => 'required|string|between:6,150',
            'description' => 'sometimes|string|max:1000|nullable',
            // 'link' => 'required|string|max:10000',
            'video' => 'required|mimes:video/quicktime | max:20000',
            'video' => 'mimes:mp4,mov,ogg,qt | max:50000',
            'category' => 'required|string|model_exists:\App\Models\Category,id',
            'tags' => 'array|nullable',
            'image' => 'required|sometimes|image',
            'label' => 'required|max:5',
            // 'language' => 'required|model_exists:\App\Models\Language,id',
            'privacy' => 'required|in:0,1,2',
            'price' => 'required|integer|between:0,100000000',
            'password' => 'sometimes|string|nullable',
        ];
    }

    public function messages()
    {
        return [
            'user_alias.*' => __('Định danh người dùng không hợp lệ'),

            'title.required' => __('Vui lòng nhập tựa đề'),
            'title.string' => __('Tựa đề không hợp lệ'),
            'title.between' => __('Tựa đề từ :min đến :max', ['min' => 6, 'max' => 150]),

            'description.string' => __('Mô tả không hợp lệ'),
            'description.max' => __('Mô tả tối đa :max kí tự', ['max' => 1000]),

            // 'link.required' => __('Vui lòng chọn đường dẫn'),
            // 'link.*' => __('Toàn bộ đường dẫn tối đa :max kí tự', ['max' => 10000]),

            'video.max' => __('Video quá dung lượng', ['max' => 20000]),
            'video.*' => __('Video không hợp lệ'),
            'video.required' => __('Vui lòng chọn video'),

            'category.*' => __('Danh mục không hợp lệ'),

            'image.*' => __('Ảnh không hợp lệ'),

            'label.required' => __('Vui lòng nhập nhãn'),
            'label.max' => __('Nhãn tối đa :max kí tự', ['max' => 5]),

            // 'language.required' => __('Vui lòng chọn ngôn ngữ'),
            // 'language.model_exists' => __('Ngôn ngữ không hợp lệ'),

            'privacy.required' => __('Vui lòng chọn quyền riêng tư'),
            'privacy.in' => __('Quyền riêng tư không hợp lệ'),

            'price.*' => __('Số tiền từ :min đến :max', ['min' => 0, 'max' => 100000000]),

            'password.string' => __('Mật khẩu không hợp lệ'),
        ];
    }
}
