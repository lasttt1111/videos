@section('meta')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta property="og:url" content="{{ route('site.watch', ['alias' => $video->alias]) }}" />
<meta property="og:type" content="video.other" />
<meta property="og:title" content="{{ $video->title }}" />
<meta property="og:description" content="{{ $video->description }}" />
<meta property="og:image" content="{{ $video->image or 'https://placehold.it/120x120' }}" />
<meta name="description" content="{{ $video->description }}">
<meta name="keywords" content="{{ implode(',', $video->tags->pluck('name')->all()) }}">
<meta name="author" content="{{ $video->user->name or __('Ai đó') }}">
@append
@section(isset($section) ? $section : 'content')
<section class="inner-video">
    <div class="row secBg">
        <div class="large-12 columns inner-flex-video">
            <div class="flex-video" style="padding-bottom: 56.25%">
                @if ($checkWatch['password'] == false)
                {{ Form::open(['url' => route('site.watch', ['alias' => $video->alias, 'redirect' => request()->fullUrl() ])]) }}
                <h2 class="text-center">{{ __('Video khóa mật khẩu') }}</h2>
                <div class="input-group">
                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                    <input name="password" class="input-group-field" type="password" placeholder="{{ __('Vui lòng nhập mật khẩu') }}" required="required">
                </div>
                <button class="button" type="submit">{{ __('Mở khóa') }}</button>
                {{ Form::close() }}
                @elseif ($checkWatch['paid'] == false)
                 {{ Form::open(['url' => route('site.pay', ['alias' => $video->alias])]) }}
                <h2 class="text-center">{{ __('Video cần phải mua') }}</h2>
                <div class="alert callout">
                    {{ __('Video cần phải mua, giá là :price (chưa phí)', ['price' => $video->price]) }}
                    <button class="button" type="submit">{{ __('Mua') }}</button>
                </div>
                {{ Form::close() }}
                @elseif ($checkWatch['privacy'] == false)
                <h2 class="text-center">{{ __('Bạn không có quyền xem video này') }}</h2>
                @else
                <div id="player">{{ __('Đang tải') }}</div>
                <iframe src="" id="embed" style="display: none;" width="100%" frameborder="0" allowfullscreen></iframe>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="SinglePostStats">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="media-object stack-for-small">
                <div class="media-object-section">
                    <div class="author-img-sec">
                        <div class="thumbnail author-single-post">
                            <a href="{{ route('site.user.profile', ['alias' => isset($video->user->alias) ? $video->user->alias : '']) }}"><img src= "{{ $video->user->avatar }}" alt="post"></a>
                        </div>
                        <p class="text-center"><a href="{{ route('site.user.profile', ['alias' => isset($video->user->alias) ? $video->user->alias : '']) }}">{{ $video->user->name }}</a></p>
                    </div>
                </div>
                <div class="media-object-section object-second">
                    <div class="author-des clearfix">
                        <div class="post-title">
                            <h4>{{ $video->title }}</h4>
                            <p>
                                <span><i class="fa fa-clock-o"></i>{{ $video->created_at }}</span>
                                <span><i class="fa fa-eye"></i>{{ $video->views }}</span>
                                <span><i class="fa fa-thumbs-o-up"></i>@if(isset($reactions['like']) && $reactions['like'] > 0)
                                {{ $reactions['like'] }}
                                @else
                                0
                                @endif
                                </span>
                                <span><i class="fa fa-thumbs-o-down"></i>@if(isset($reactions['dislike']) && $reactions['dislike'] > 0)
                                {{ $reactions['dislike'] }}
                                @else
                                0
                                @endif
                                </span>
                                <span><i class="fa fa-commenting"></i><span class="fb-comments-count"></span></span>
                            </p>
                        </div>
                        <div class="subscribe">
                            <form action="javascript:void(0)">
                                @if (!Auth::check() || empty($video->user) || Auth::user()->id != $video->user->id)
                                <button name="subscribe" id="subscribe">@if ($userSubscribe) <i class="fa fa-check"></i>@endif{{ __('Đăng kí') }}</button>
                                @endif

                                @auth
                                @if (((empty($video->user) || Auth::user()->id == $video->user->id) || Auth::user()->permission < 3))
                                <a href="{{ route('site.upload.video.edit', ['alias' => $video->alias]) }}">
                                    <button type="button"><i class="fa fa-pencil"></i> {{ __('Chỉnh sửa') }}</button>
                                </a>
                                @endif
                                @if (empty($video->user) || Auth::user()->id != $video->user->id)
                                <a href="{{ route('site.report', ['alias' => $video->alias]) }}">
                                    <button type="button"><i class="fa fa-warning"></i>{{ __('Báo cáo') }}</button>
                                </a>
                                @endif
                                @endauth
                            </form>
                        </div>
                    </div>
                    <div class="social-share">
                        <div class="post-like-btn clearfix">
                            <form action="javascript:void(0)">
                                <button type="button" name="fav"><i class="fa fa-heart"></i>{{ __('Thêm vào') }}</button>
                            </form>
                            <a href="javascript:void(0)" class="secondary-button reaction" data-reaction="like"><i class="fa fa-thumbs-o-up"></i></a>
                            <a href="javascript:void(0)" class="secondary-button reaction" data-reaction="dislike"><i class="fa fa-thumbs-o-down"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End single post stats -->
<section class="singlePostDescription">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="heading">
                <h5>{{ __('Server') }}</h5>
            </div>
            <div class="description showmore_one" style="padding-bottom: 10px">
                {{-- @foreach ($video->links as $k => $l)
                <button class="button select-link" data-server="{{ $k }}" @if(!$canView) disabled="disabled" @endif>{{ $l }}</button>
                @endforeach --}}
                <button class="button select-link" @if(!$canView) disabled="disabled" @endif>Videos</button>
            </div>
        </div>
    </div>
</section>
<!-- single post description -->
<section class="singlePostDescription">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="heading">
                <h5>{{ __('Mô tả') }}</h5>
            </div>
            <div class="description showmore_one">
                <p>
                    {!!  nl2br(htmlspecialchars($video->description)) !!}
                </p>
                <div class="categories">
                    <button><i class="fa fa-folder"></i>{{ __('Danh mục') }}</button>
                    <a href="{{ route('site.category.category', ['alias' => isset($video->category->alias) ? $video->category->alias: '']) }}" class="inner-btn">{{ $video->category->title }}</a>
                </div>
                <div class="tags" style="padding-bottom: 10px">
                    <button><i class="fa fa-tags"></i>{{ __('Thẻ') }}</button>
                    @foreach ($video->tags as $tag)
                    <a href="{{ route('site.tag.info', ['alias' => $tag->alias]) }}" class="inner-btn">{{ $tag->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@if ($canView)
<section class="content comments">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="main-heading borderBottom">
                <div class="row padding-14">
                    <div class="medium-12 small-12 columns">
                        <div class="head-title">
                            <i class="fa fa-comments"></i>
                            <h4>{{ __('Bình luận') }} <span class="fb-comments-count"></span></h4>
                        </div>
                    </div>
                </div>
            </div>
            <h2></h2>
            <div class="fb-comments" data-href="{{ route('site.watch', ['alias' => $video->alias]) }}" data-width="100%" data-numposts="10"></div>
        </div>
    </div>
</section>
@endif
@stop
@section('head')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0&appId=417363401765642&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@stop
@section('beforeEnd')
<script type="text/javascript" src="https://content.jwplatform.com/libraries/Fuo0tIkV.js"></script>
<style type="text/css" media="screen">
.selected-reaction{
    background-color: #e96969;
}
.selected-reaction > i {
    color: white;
}
</style>
@stop
@section('ready-script')
$('#subscribe').click(function(){
    @if (Auth::check())
    $.ajax({
        url: "{{ route('site.user.subscribe', ['alias' => isset($video->user->alias) ? $video->user->alias : '']) }}",
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
$('.select-link').click(function(){
    loadVideo($(this).data('server'))
})
loadVideo(0);
function loadVideo(server){
    $.ajax({
        url: "{{ route('site.link', ['alias' => $video->alias]) }}?server=" + server,
        method: "get",
        dataType: "json",
        success: function (data){
            if (data.status == 200){
            console.log(data.data.link);
                jwplayer("player").setup({
                    file: data.data.link,
                    title: "{{ $video->title }}",
                    image: data.data.image ? data.data.image : "{{ $video->image }}"
                })
            $(".select-link[data-server='"+ server +"']").attr('disabled', 'disabled')
            $(".select-link[data-server!='"+ server +"']").attr('disabled', false)
        	}
        }
    });
}
function toggleReaction(reaction){
    $('.reaction[data-reaction="' + reaction + '"]').toggleClass('selected-reaction')
    $('.reaction[data-reaction!="' + reaction + '"]').removeClass('selected-reaction')
}
toggleReaction("{{ $userReaction }}")
$('.reaction').click(function(){
    @if (Auth::check())
    var _this = $(this)
    $.ajax({
        url: "{{ route('site.reaction', ['alias' => $video->alias]) }}",
        method: "post",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}",
            reaction: $(this).data('reaction')
        },
        success: function (data){
            if (data.status == 200){
                toggleReaction(_this.data('reaction'))
            }
        }
    })
    @else
    window.location.href = "{{ route('site.login') }}"
    @endif
})
@auth
$('button[name="fav"]').click(function(){
    addToPlaylist("{{ $video->alias }}")
})
@endauth
@stop