@php 
    \App\Helpers\Content::setData('oneColumn', true);
@endphp
@if($video)
@includeIf('site/video_watch', $video + ['section' => 'watch'])
@endif
@section('content')
<div class="row">
    <div class="large-8 columns">
        @if($video)
        @yield('watch')
        @else
        <div style="height: 490px; text-align: center;">
            <h3>Không có video nào</h3>
        </div>
        @endif
    </div>
    <div class="large-4 columns">
        <aside class="secBg sidebar">
            <div class="row">
                <div class="large-12 medium-7 medium-centered columns">
                    <div class="widgetBox">
                        <div class="widgetTitle">
                            <h5>{{ __('Danh sách (tổng cộng: :total)', ['total' => count($list)]) }}</h5>
                        </div>
                        <div class="widgetContent">
                            @foreach ($list as $v)
                            <div class="media-object stack-for-small">
                                <div class="media-object-section">
                                    <div class="recent-img">
                                        <img src= "{{ $v->image }}" alt="{{ $v->title }}">
                                        <a href="{{ route('site.playlist.playlist', ['alias' => $playlist->alias, 'v' => $v->pivot->position]) }}" class="hover-posts">
                                            <span><i class="fa fa-play"></i></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="media-object-section">
                                    <div class="media-content">
                                        @if (isset($video['video']->id) && $video['video']->id == $v->id)
                                        <h6>{{ __('Đang phát') }}</h6>
                                        @else
                                        <h6><a href="{{ route('site.playlist.playlist', ['alias' => $playlist->alias, 'v' => $v->pivot->position]) }}">{{ $v->title }}</a></h6>
                                        <p>
                                            <i class="fa fa-user"></i>
                                            <span><a href="{{ route('site.user.profile', ['alias' => isset($v->user->alias) ? $v->user->alias : '']) }}">{{ $v->user->name }}</a></span>
                                            <i class="fa fa-clock-o"></i>
                                            <span>{{ $v->created_at }}</span>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@stop
