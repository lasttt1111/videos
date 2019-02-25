@section('content')
<section class="registration">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="login-register-content">
                <div class="row collapse borderBottom">
                    <div class="medium-6 large-centered medium-centered">
                        <div class="page-heading text-center">
                            <h3>{{ __('Báo cáo') }}</h3>
                            <p>{{ __('Bạn đã chọn báo cáo cho video :name', ['name' => $video->title]) }}</p>
                        </div>
                    </div>
                </div>
                <div class="row" data-equalizer="ofeseo-equalizer" data-equalize-on="medium" id="test-eq" data-resize="rkvpo1-eq" data-events="resize">
                    <div class="large-12 columns">
                        <h4>{{ $video->title }}</h4>
                        <p>{{ __('Đường dẫn gốc: :url', ['url' => route('site.watch', ['alias' => $video->alias])]) }}</p>
                        <div class="register-form">
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
                            @elseif (isset($success))
                            <div data-alert class="callout success">
                                {{ __('Gửi báo cáo thành công') }}
                            </div>
                          @endif
                          {{ Form::open() }}
                          {{ Form::select('type', ['', __('Video đã có người đăng'), __('Link virus'), __('Link chết'), __('Nội dung không phù hợp'), __('Nội dung vi phạm pháp luật')], '', ['id' => 'report_type']) }}
                          <textarea required="required" name="message" id="report" placeholder="{{ __('Nội dung báo cáo') }}" style="color: red;"></textarea>
                          {!! Recaptcha::render() !!}
                          <button class="button expanded" type="submit" name="submit">{{ __('Báo cáo') }}</button>
                          {{ Form::close() }}
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@stop
@section('ready-script')
$("#report_type").change(function(){
$("#report").html($(this).find("option:selected").text())
})
@append