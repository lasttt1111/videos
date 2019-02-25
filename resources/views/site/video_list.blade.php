@section('content')
<section class="content">
    <div class="main-heading">
        <div class="row secBg padding-14">
            <div class="medium-12 small-12 columns">
                <div class="head-title">
                    <i class="fa fa-film"></i>
                    <h4>{{ __('Danh sách video') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="row column head-text clearfix">
                <p class="pull-left">{{ __('Tổng cộng :number video', ['number' => $video->total()]) }}</span></p>
            </div>
            <div class="tabs-content" data-tabs-content="newVideos">
                <div class="tabs-panel is-active" id="new-all">
                    <div class="row list-group">
                        @foreach ($video as $key => $v)
                        <div class="item large-6 medium-6 columns group-item-grid-default @if($loop->last) end @endif">
                            <div class="post thumb-border post-video" 
                                    data-user-alias="{{ $v->user->alias or '' }}" 
                                    data-video-alias="{{ $v->alias }}"
                                    data-user-subscribe-url="{{ route('site.user.subscribe', ['alias' => isset($v->user->alias) ? $v->user->alias : '']) }}"
                            >
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
                                    <h6 title="{{ $v->title }}"><a href="{{ route('site.watch', ['alias' => $v->alias]) }}">{{ str_limit($v->title, 30) }}</a></h6>
                                    <div class="post-stats clearfix">
                                        <p class="pull-left">
                                            <i class="fa fa-user"></i>
                                            <span><a href="{{ route('site.user.profile', ['alias' => isset($v->user->alias) ? $v->user->alias : '']) }}">{{ $v->user->name or __('Ai đó')}}</a></span>
                                        </p>
                                        <p class="pull-left">
                                            <i class="fa fa-clock-o"></i>
                                            <span>{{ $v->created_at->format('Y-m-d') }}</span>
                                        </p>
                                        <p class="pull-left">
                                            <i class="fa fa-eye"></i>
                                            <span>{{ $v->views }}</span>
                                        </p>
                                    </div>
                                    <div class="post-summary">
                                        <p>{{ $v->description }}</p>
                                    </div>
                                    <div class="post-button">
                                        <a href="single-video-v2.html" class="secondary-button"><i class="fa fa-play-circle"></i>watch video</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center row-btn">
                @includeIf('site/pagination', ['paginator' => $video])
            </div>
        </div>
    </div>
</section>
@stop