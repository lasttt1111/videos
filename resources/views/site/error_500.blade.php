@section('content')
<section class="error-page">
    <div class="row secBg">
        <div class="large-8 large-centered columns">
            <div class="error-page-content text-center">
                <div class="error-img text-center">
                </div>
                <h1>{{ __('Có lỗi nghiêm trọng xảy ra, thử lại sau') }}</h1>
                <p></p>
                <a href="{{ route('site.index') }}" class="button">{{ __('Trở về trang chủ') }}</a>
            </div>
        </div>
    </div>
</section>
@stop