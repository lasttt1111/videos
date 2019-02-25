@section('meta')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta property="og:url" content="{{ route('site.index') }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ __('Trang chia sẻ video') }}" />
<meta property="og:description" content="{{ __('Chia sẻ video') }}" />
<meta name="description" content="{{ __('Chia sẻ video') }}">
@append
@php \App\Helpers\Content::setData('oneColumn', true) @endphp
@section('content')
<section id="premium" class="premium-v4">
    <div id="owl-demo" class="owl-carousel carousel" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-responsive-small="1" data-responsive-medium="2" data-responsive-xlarge="5">
        @foreach ( $most as $video )
        <div class="item">
            <figure class="premium-img">
                <img src="{{ $video->image }}" alt="carousel">
                <figcaption>
                    <h5>{{ str_limit($video->title, 20) }}</h5>
                    <p>{{ $video->user->name }}</p>
                </figcaption>
            </figure>
            <a href="{{ route('site.watch', ['alias' => $video->alias]) }}" class="hover-posts">
                <span><i class="fa fa-play"></i>{{ __('Xem video') }}</span>
            </a>
        </div>
        @endforeach
    </div>
</section>
<section class="content">
    <div class="main-heading">
        <div class="row secBg padding-14">
            <div class="medium-12 small-12 columns">
                <div class="head-title">
                    <i class="fa fa-film"></i>
                    <h4>{{ __('Video mới nhất') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="row column head-text clearfix">
            </div>
            <div class="tabs-content" data-tabs-content="newVideos">
                <div class="tabs-panel is-active" id="new-all">
                    <div class="row list-group">
                        @foreach ($newest as $key => $video)
                        <div class="item large-3 medium-6 columns group-item-grid-default @if($loop->last) end @endif">
                            <div class="post thumb-border post-video" data-user-alias="{{ $video->user->alias or '' }}" data-video-alias="{{ $video->alias }}" data-user-subscribe-url="{{ route('site.user.subscribe', ['alias' => isset($video->user->alias) ? $video->user->alias : '']) }}">
                                <div class="post-thumb">
                                    <img src="{{ $video->image }}" alt="new video">
                                    <a href="{{ route('site.watch', ['alias' => $video->alias]) }}" class="hover-posts">
                                        <span><i class="fa fa-play"></i>{{ __('Xem video') }}</span>
                                    </a>
                                    <div class="video-stats clearfix">
                                        <div class="thumb-stats pull-left">
                                            <h6>{{ $video->label }}</h6>
                                        </div>
                                        @if ($video->has_password)
                                        <div class="thumb-stats pull-left">
                                            <i class="fa fa-lock"></i>
                                            <span>{{ __('Khóa mật khẩu') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="post-des">
                                    <h6 title="{{ $video->title }}"><a href="{{ route('site.watch', ['alias' => $video->alias]) }}">{{ str_limit($video->title, 30) }}</a></h6>
                                    <div class="post-stats clearfix">
                                        <p class="pull-left">
                                            <i class="fa fa-user"></i>
                                            <span><a href="{{ route('site.user.profile', ['alias' => isset($video->user->alias) ? $video->user->alias : '']) }}">{{ $video->user->name }}</a></span>
                                        </p>
                                        <p class="pull-left">
                                            <i class="fa fa-clock-o"></i>
                                            <span>{{ $video->created_at->format('Y-m-d') }}</span>
                                        </p>
                                        <p class="pull-left">
                                            <i class="fa fa-eye"></i>
                                            <span>{{ $video->views }}</span>
                                        </p>
                                    </div>
                                    <div class="post-summary">
                                        <p>{{ $video->description }}</p>
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
                <a class="button radius" href="{{ route('site.video') }}">{{ __('Xem toàn bộ') }}</a>
            </div>
        </div>
    </div>
</section>
<section id="category">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="column row">
                <div class="heading category-heading clearfix">
                    <div class="cat-head pull-left">
                        <i class="fa fa-folder-open"></i>
                        <h4>{{ __('Danh mục') }}</h4>
                    </div>
                    <div>
                        <div class="navText pull-right show-for-large">
                            <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                            <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="owl-demo-cat" class="owl-carousel carousel" data-autoplay="true" data-autoplay-timeout="4000" data-autoplay-hover="true" data-car-length="5" data-items="6" data-dots="false" data-loop="true" data-auto-width="true" data-margin="10">
                @foreach ($categories as $category)
                <div class="item-cat item thumb-border">
                    <figure class="premium-img">
                        <img src="{{ $category->image }}" alt="carousel">
                        <a href="{{ route('site.category.category', ['alias' => $category->alias]) }}" class="hover-posts">
                            <span><i class="fa fa-search"></i></span>
                        </a>
                    </figure>
                    <h6><a href="{{ route('site.category.category', ['alias' => $category->alias]) }}">{{ str_limit($category->title, 20) }}</a></h6>
                </div>
                @endforeach
            </div>
            <div class="row collapse">
                <div class="large-12 columns text-center row-btn">
                    <a href="{{ route('site.category.index') }}" class="button radius">{{ __('Xem toàn bộ') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('beforeEnd')

@stop