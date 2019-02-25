@section('content')
<section class="content content-with-sidebar">
    <div class="main-heading removeMargin">
        <div class="row secBg padding-14 removeBorderBottom">
            <div class="medium-12 small-12 columns">
                <div class="head-title">
                    <i class="fa fa-film"></i>
                    <h4>{{ __('Thẻ :tag', ['tag' => $tag->title]) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="row column head-text clearfix">
                <p class="pull-left">{{ __('Tổng video :number', ['number' => $video->total()]) }}</p>
            </div>
            <div class="tabs-content" data-tabs-content="newVideos">
                <div class="tabs-panel is-active" id="new-all" role="tabpanel" aria-hidden="false" aria-labelledby="new-all-label">
                    <div class="row list-group">
                        @foreach ($video as $k => $v)
                        <div class="item large-4 medium-6 columns grid-medium">
                            <div class="post thumb-border post-video" data-user-alias="{{ $v->user->alias }}" data-video-alias="{{ $v->alias }}">
                                <div class="post-thumb">
                                    <img src="{{ $v->image }}" alt="new video">
                                    <a href="{{ route('site.watch', ['alias' => $v->alias]) }}" class="hover-posts">
                                        <span><i class="fa fa-play"></i>{{ __('Xem video') }}</span>
                                    </a>
                                    <div class="video-stats clearfix">
                                        <div class="thumb-stats pull-left">
                                            <h6>{{ $v->label }}</h6>
                                        </div>
                                        @if ($v->has_password)
                                        <div class="thumb-stats pull-left">
                                            <i class="fa fa-lock"></i>
                                            <span>{{ __('Khóa mật khẩu') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="post-des">
                                    <h6><a href="{{ route('site.watch', ['alias' => $v->alias]) }}">{{ $v->title }}</a></h6>
                                    <div class="post-stats clearfix">
                                        <p class="pull-left">
                                            <i class="fa fa-user"></i>
                                            <span><a href="#">{{ $v->user->name }}</a></span>
                                        </p>
                                        <p class="pull-left">
                                            <i class="fa fa-clock-o"></i>
                                            <span>{{ $v->created_at }}</span>
                                        </p>
                                        <p class="pull-left">
                                            <i class="fa fa-eye"></i>
                                            <span>{{ $v->views }}</span>
                                        </p>
                                    </div>
                                    <div class="post-summary">
                                        <p>{{ str_limit($v->description, 50) }}</p>
                                    </div>
                                    <div class="post-button">
                                        <a href="{{ route('site.watch', ['alias' => $v->alias]) }}" class="secondary-button"><i class="fa fa-play-circle"></i>{{ __('Xem video') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
           @includeIf('site/pagination', ['paginator' => $video])
        </div>
    </div>
</section>
@stop