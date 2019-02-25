@php
\App\Helpers\Content::setData('oneColumn', true);
@endphp
@section('content')
<section class="topProfile" style="background-image: url({{ $user->cover }})">
    <div class="profile-stats">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="profile-author-img">
                    <img src="{{ $user->avatar }}" alt="{{ $user->name or __('Ai đó') }}">
                </div>
                <div class="profile-subscribe">
                    <span><i class="fa fa-users"></i>{{ $user->subscribers()->count() }}</span>
                    <button type="button" id="subscribe">{{ __('Đăng kí') }}</button>
                </div>
                <div class="clearfix">
                    <div class="profile-author-name float-left">
                        <h4>{{ $user->name }}</h4>
                        <p>{{ __('Ngày tham gia: :date', ['date' => $user->created_at->format('Y-m-d') ]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="large-4 columns">
        <aside class="secBg sidebar">
            <div class="row">
                <div class="large-12 columns">
                    <div class="widgetBox">
                        <div class="widgetTitle">
                            <h5>{{ __('Tổng quan') }}</h5>
                        </div>
                        <div class="widgetContent">
                            <ul class="profile-overview">
                                <li class="clearfix"><a href="{{ route('site.user.profile', ['alias' => $user->alias]) }}" class="{{ \App\Helpers\Content::getData('user_menu') == 'video' ? 'active' : ''}}"><i class="fa fa-video-camera"></i>{{ __('Video') }} <span class="float-right">{{ $user->video()->count() }}</span></a></li>

                                 <li class="clearfix"><a href="{{ route('site.user.playlist', ['alias' => $user->alias]) }}" class="{{ \App\Helpers\Content::getData('user_menu') == 'playlist' ? 'active' : ''}}"><i class="fa fa-list" aria-hidden="true"></i>{{ __('Danh sách phát') }} <span class="float-right">{{ $user->playlist()->count() }}</span></a></li>

                                <li class="clearfix"><a href="{{ route('site.user.subscription', ['alias' => $user->alias]) }}" class="{{ \App\Helpers\Content::getData('user_menu') == 'subscriber' ? 'active' : ''}}"><i class="fa fa-users"></i>{{ __('Đang theo dõi') }}<span class="float-right">{{ $user->subscribers()->count() }}</span></a></li>
                                @if (Auth::check() && Auth::user()->id == $user->id)
                                <li class="clearfix"><a href="{{ route('site.user.info', ['alias' => $user->alias]) }}" class="{{ \App\Helpers\Content::getData('user_menu') == 'info' ? 'active' : ''}}"><i class="fa fa-gears"></i>{{ __('Chỉnh sửa thông tin') }}<span class="float-right"></span></a></li>
                                <li class="clearfix"><a href="{{ route('site.logout') }}"><i class="fa fa-sign-out"></i>{{ __('Đăng xuất') }}<span class="float-right"></span></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
    <div class="large-8 columns profile-inner">
        <section class="profile-videos">
            <div class="row secBg">
                <div class="large-12 columns">
                    @yield('user_content')
                </div>
            </div>
        </section>
    </div>
</div>
@stop
@section('ready-script')
        @if (Auth::check() && Auth::user()->alias != $user->alias)
        $('#subscribe').click(function(){
            @if (Auth::check())
            $.ajax({
                url: "{{ route('site.user.subscribe', ['alias' => $user->alias]) }}",
                method: "post",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(data){
                    Lobibox.notify('success', {
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        msg: "{{ __('Thành công thao tác của bạn đã lưu') }}"
                    });
                }
            })
            @else
            window.location.href = "{{ route('site.login') }}"
            @endif
        })
    @endif
@stop