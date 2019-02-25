@section('content')
<div class="profile-inner">
    <section class="submit-post">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="heading">
                    <i class="fa fa-pencil-square-o"></i>
                    <h4>{{ __('Chỉnh sửa video') }}</h4>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        {{Form::open(['url' => route('site.upload.video.edit', ['alias' => $video->alias]), 'enctype' => 'multipart/form-data', 'method' => 'put'])}}
                        @if ($errors->count() > 0)
                        <div data-abide-error="" class="alert callout">
                            <p><i class="fa fa-exclamation-triangle"></i> {{ __('Có lỗi xảy ra') }}
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                        @endif
                        <div class="row">
                            <div class="large-12 columns">
                                <label>{{ __('Tựa đề') }}
                                    <input type="text" name="title" placeholder="{{ __('Tựa đề cho video') }}" required="required" value="{{ $video->title }}">
                                </label>
                            </div>
                            <div class="large-12 columns">
                                <label>{{ __('Mô tả') }}
                                    <textarea name="description">{{ $video->description }}</textarea>
                                </label>
                            </div>
                            <div class="large-12 columns">
                                <div class="post-category">
                                        <label>{{ __('Chọn danh mục') }}
                                            {{ Form::select('category', $categories, $video->category_id) }}
                                        </label>
                                    </div>
                                    <div class="post-category">
                                        <label>{{ __('Chọn thẻ') }}
                                            {{ Form::select('tags[]', $tags, $video->tags->pluck('id')->all(), ['multiple' => 'multiple']) }}
                                        </label>
                                    </div>
                                <div class="upload-video">
                                    <label for="imgUpload" class="button">{{ __('Chọn ảnh') }}</label>
                                    <input type="file" name="image" class="show-for-sr" id="imgUpload">
                                    <span>{{ __('Chưa chọn file') }}</span>
                                </div>
                            </div>
                            <div class="large-12 columns">
                                <label>{{ __('Nhãn') }}
                                    <input type="text" name="label" maxlength="5" required="required" value="{{ $video->label }}">
                                </label>
                                <p>{{ __('Ví dụ: HD, SD, 1080p...') }}</p>
                            </div>
                            <div class="large-12 columns" hidden>
                                    <label>{{ __('Ngôn ngữ video') }}
                                        {{ Form::select('language', $languages, $video->language) }}
                                    </label>
                                </div>
                            <div class="large-12 columns">
                                <label>{{ __('Quyền riêng tư') }}
                                    {{ Form::select('privacy', [__('Công khai'), __('Không công khai'), __('Riêng tư')], $video->privacy) }}
                                </label>
                            </div>
                            <div class="large-12 columns" hidden>
                                <label>{{ __('Giá xem') }}
                                    <input type="number" min="0" placeholder="{{ __('Giá tiền') }}" value="{{ $video->price }}" name="price">
                                </label>
                            </div>
                            <div class="large-12 columns">
                                <label>{{ __('Mật khẩu') }}
                                    <input type="password" placeholder="{{ __('Mật khẩu (không bắt buộc)') }}" value="" name="password" style="margin-bottom: 5px;">
                                </label>
                                @if ($video->has_password)
                                <label class="container" style="padding-left: 30px; padding-bottom: 15px;"> {{ __('Gỡ bỏ mật khẩu') }}
                                  <input type="checkbox" name="remove-password">
                                  <span class="checkmark"></span>
                              </label>
                              @endif
                            </div>
                            <div class="large-12 columns">
                                {!! Recaptcha::render() !!}
                            </div>
                          <div class="large-12 columns">
                            <button class="button expanded" type="submit" name="submit">{{ __('Hoàn tất chỉnh sửa') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<div style="display: none" id="link-modal-wrapper">
    <div class="submit-post" id="link-modal">
        <div class="group-link">
            <label>{{ __('Tên liên kết') }}
                <input type="text" name="link-name" placeholder="{{ __('Tên liên kết không bắt buộc') }}">
            </label>
            <label>{{ __('Liên kết') }}<font color="red">*</font>
                <input type="text" name="link" placeholder="{{ __('Liên kết (bắt buộc)') }}">
            </label>
            <label class="container" style="padding-left: 30px"> {{ __('Nhúng') }}
              <input type="checkbox">
              <span class="checkmark"></span>
          </label>
          <hr />
      </div>
  </div>
</div>
@stop
@section('beforeEnd')
<style>
/* The container */
.container {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>
@stop