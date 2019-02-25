@section('content')
<div class="profile-inner">
    <section class="submit-post">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="heading">
                    <i class="fa fa-pencil-square-o"></i>
                    <h4>{{ __('Thêm danh sách phát mới') }}</h4>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        {{Form::open(['url' => route('site.upload.playlist.add'), 'enctype' => 'multipart/form-data'])}}
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
                                <label>{{ __('Tên danh sách phát') }}
                                    <input type="text" name="title" placeholder="{{ __('Tựa đề cho danh sách phát') }}" required="required" value="{{ old('title') }}">
                                </label>
                                <label>{{ __('Quyền riêng tư') }}
                                    {{ Form::select('privacy', [__('Công khai'), __('Không công khai'), __('Riêng tư')]) }}
                                </label>
                                <div class="upload-video">
                                    <label for="imgUpload" class="button">{{ __('Chọn ảnh đại diện') }}</label>
                                    <input type="file" name="image" class="show-for-sr" id="imgUpload">
                                    <span>{{ __('Chưa chọn file') }}</span>
                                </div>
                                {!! Recaptcha::render() !!}
                            </div>
                            <div class="large-12 columns">
                                <button class="button expanded" type="submit" name="submit">{{ __('Tạo danh sách phát') }}</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
@section('ready-script')
$("#imgUpload").change(function(e){
    if (e.target.files && e.target.files[0].name){
        $(this).parent().find('span').html(e.target.files[0].name)
    }
})
@stop