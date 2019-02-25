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
                <p class="pull-left">{{ __('Tổng cộng :number danh sách phát', ['number' => $playlists->total()]) }}</span></p>
            </div>
            <div class="tabs-content" data-tabs-content="newVideos">
                <div class="tabs-panel is-active" id="new-all">
                    <div class="row list-group">
                        @foreach ($playlists as $key => $p)
                        <div class="item large-6 medium-6 columns group-item-grid-default @if($loop->last) end @endif">
                            <div class="post thumb-border post-playlist" 
                                    data-user-alias="{{ $p->user->alias or '' }}" 
                                    data-playlist-alias="{{ $p->alias }}"
                                    data-user-subscribe-url="{{ route('site.user.subscribe', ['alias' => isset($p->user->alias) ? $p->user->alias : '']) }}"
                            >
                                <div class="post-thumb">
                                    <img src="{{ $p->image }}" alt="new video">
                                    <a href="{{ route('site.playlist.playlist', ['alias' => $p->alias]) }}" class="hover-posts">
                                        <span><i class="fa fa-play"></i>{{ __('Xem danh sách phát') }}</span>
                                    </a>
                                </div>
                                <div class="post-des">
                                    <h6 title="{{ $p->title }}"><a href="{{ route('site.playlist.playlist', ['alias' => $p->alias]) }}">{{ str_limit($p->title, 30) }}</a></h6>
                                    <div class="post-stats clearfix">
                                        <p class="pull-left">
                                            <i class="fa fa-user"></i>
                                            <span><a href="{{ route('site.user.profile', ['alias' => isset($p->user->alias) ? $p->user->alias : '']) }}">{{ $p->user->name }}</a></span>
                                        </p>
                                        <p class="pull-left">
                                            <i class="fa fa-clock-o"></i>
                                            <span>{{ $p->created_at ? $p->created_at->format('Y-m-d') : '' }}</span>
                                        </p>
                                    </div>
                                    <div class="post-summary">
                                        <p>{{ $p->description }}</p>
                                    </div>
                                    <div class="post-button">
                                        <a href="{{ route('site.playlist.playlist', ['alias' => $p->alias]) }}" class="secondary-button"><i class="fa fa-play-circle"></i>{{ __('Xem danh sách phát') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center row-btn">
                @includeIf('site/pagination', ['paginator' => $playlists])
            </div>
        </div>
    </div>
</section>
@stop