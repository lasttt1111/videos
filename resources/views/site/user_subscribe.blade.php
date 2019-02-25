@php \App\Helpers\Content::setData('user_menu', 'subscriber'); @endphp
@section ('user_content')
<section class="content content-with-sidebar followers margin-bottom-10">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="row column head-text clearfix">
                <h4 class="pull-left"><i class="fa fa-users"></i>{{ __('Danh sách người đang đăng kí') }}</h4>
            </div>
            <div class="row collapse">
                @foreach ($subscribers as $s)
                <div class="large-2 small-6 medium-3 columns">
                    <div class="follower">
                        <a href="{{ route('site.user.profile', ['alias' => $s->alias]) }}">
                            <div class="follower-img">
                                <img src="{{ $s->avatar }}" alt="{{ $s->name }}">
                            </div>
                            <span>{{ $s->name }}</span>
                        </a>
                        <button type="button" name="subscribe" data-user-alias="{{ $s->alias }}" data-user-subscribe-url="{{ route('site.user.subscribe', ['alias' => $s->alias]) }}">{{ __('Đăng kí') }}</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@includeIf('site/pagination', ['paginator' => $subscribers])
@stop

@includeIf('site/user_template')

@section ('ready-script')
    @if (Auth::check() && Auth::user()->alias != $user->alias)
    $('button[name="subscribe"]').click(function(){
        @if (Auth::check())
        $.ajax({
            url: $(this).data("user-subscribe-url"),
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
@append