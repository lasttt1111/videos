@section('content')
<section class="error-page">
    <div class="row secBg">
        <div class="large-8 large-centered columns">
            <div class="error-page-content text-center">
                <div class="error-img text-center">
                    <img src="{{ asset('site/images/404-error.png') }}" alt="404 page">
                    <div class="spark">
                        <img class="flash" src="{{ asset('site/images/spark.png') }}" alt="spark">
                    </div>
                </div>
                <h1>{{ __('Không tìm thấy trang') }}</h1>
                <p></p>
                <a href="{{ route('site.index') }}" class="button">{{ __('Trở về trang chủ') }}</a>
            </div>
        </div>
    </div>
</section>
@stop