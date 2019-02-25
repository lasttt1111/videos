@php
    $video = \App\Helpers\Content::getNewestVideo(12);
@endphp
<aside class="secBg sidebar">
    <div class="row">
        <div class="large-12 medium-7 medium-centered columns">
            <div class="widgetBox">
                <div class="widgetTitle">
                    <h5>{{ __('Video mới nhất') }}</h5>
                </div>
                <div class="widgetContent">
                    @foreach ($video as $v)
                    <div class="media-object stack-for-small">
                        <div class="media-object-section">
                            <div class="recent-img">
                                <img src= "{{ $v->image }}" alt="{{ $v->title }}">
                                <a href="{{ route('site.watch', ['alias' => $v->alias]) }}" class="hover-posts">
                                    <span><i class="fa fa-play"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="media-object-section">
                            <div class="media-content">
                                <h6><a href="{{ route('site.watch', ['alias' => $v->alias]) }}">{{ $v->title }}</a></h6>
                                <p>
                                    <i class="fa fa-user"></i>
                                    <span><a href="{{ route('site.user.profile', ['alias' => isset($v->user->alias) ? $v->user->alias : '']) }}">{{ $v->user->name }}</a></span>
                                    <i class="fa fa-clock-o"></i>
                                    <span>{{ $v->created_at }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</aside>