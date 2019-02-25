@includeIf('site/'.$module.'_'.$function)
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('site/css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('site/css/theme.css')}}">
    <link rel="stylesheet" href="{{ asset('site/css/font-awesome.min.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/layerslider.css')}}">
    <link rel="stylesheet" href="{{ asset('site/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('site/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('site/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/lobibox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/jquery.contextMenu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/jquery.contextMenuCommon.min.css') }}">
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @yield('meta')
    @yield('head')
</head>
<body>
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            @include('site/menu')
            <div class="off-canvas-content" data-off-canvas-content>
                <header>
                    <section id="navBar">
                        <nav class="sticky-container" data-sticky-container>
                            <div class="sticky topnav" data-sticky data-top-anchor="navBar" data-btm-anchor="footer-bottom:bottom" data-margin-top="0" data-margin-bottom="0" style="width: 100%; background: #fff;" data-sticky-on="large">
                                <div class="title-bar" data-responsive-toggle="beNav" data-hide-for="large">
                                    <button class="menu-icon" type="button" data-toggle="offCanvas"></button>
                                    <div class="title-bar-title">
                                        <img src="{{ asset('logo.png') }}" alt="logo">
                                    </div>
                                </div>
                                <div class="show-for-large topbar-full clearfix" id="beNav" style="width: 100%;">
                                    <div class="top-bar-left btn-toggle">
                                        <button type="button" data-toggle="offCanvas" class="secondary-button"><i class="fa fa-bars"></i></button>
                                    </div>
                                    <div class="top-bar-left toplogo">
                                        <ul class="menu">
                                            <li class="menu-text">
                                                <a href="{{ route('site.index') }}">
                                                    <img width="20%" src="{{ asset('logo.png') }}" alt="logo">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="top-bar-left topsearch">
                                        <div class="search-bar-full">
                                            <form method="get" action="{{ route('site.search') }}">
                                                <div class="input-group">
                                                    <input class="input-group-field" type="search" name="q" placeholder="{{ __('Nhập vào từ khóa') }}" value="{{ \Request::get('q', '') }}">
                                                    <div class="input-group-button icon-btn">
                                                        <input class="button" type="submit" value="">
                                                        <i class="fa fa-search"></i>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="top-bar-left topbtn">
                                        <div class="top-button">
                                            <ul class="menu float-right">
                                                <li>
                                                    <a href="{{ route('site.upload.video.add') }}">{{ __('Thêm mới video') }}</a>
                                                </li>
                                                @guest
                                                <li>
                                                    <a href="{{ route('site.login') }}">{{ __('Đăng nhập / đăng kí') }}</a>
                                                </li>
                                                @endguest
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </section>
                </header>
                <div class="row">
                    @if (!\App\Helpers\Content::getData('oneColumn'))
                    <div class="large-8 columns">
                        @yield('content')
                    </div>
                    <div class="large-4 columns">
                        @yield('sidebar')
                        @includeIf('site/right')
                    </div>
                    @else
                    <div class="large-12 columns">
                        @yield('content')
                    </div>
                    @endif
                </div>
            </div>
            @includeIf('site/footer')
            <div id="footer-bottom">
                <div class="logo text-center">
                </div>
                <div class="btm-footer-text text-center">
                    <p>{{ date('Y') }} © Video</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display: none">
    <div id="playlist-modal">
        <label>{{ __('Tên playlist') }}
            <input type="text" name="playlist-name" placeholder="{{ __('Tên playlist') }}">
        </label>
        <button type="button" class="button" id="search-playlist">{{ __('Tìm kiếm') }}</button>
        <ul class="result">

        </ul>
    </div>
</div>
<script src="{{ asset('site/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('site/js/lobibox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/messageboxes.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/notifications.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/jquery-ui-position.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/jquery.contextMenu.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/jquery.contextMenuCommon.min.js') }}"></script>
@yield('beforeEnd')

<script type="text/javascript">
    jQuery(document).ready(function($){
        var user = "{{ Auth::check() ? Auth::user()->alias : '' }}"
        var video_alias = "";
        function addToPlaylist(alias){
            Lobibox.window({
                title: "{{ __('Thêm vào playlist') }}",
                closeButton: true,
                draggable: true,
                content: $('#playlist-modal'),
                width: jQuery(document).width() * 60 / 100,
                buttons: {
                    close: {
                        text: "<i class='fa fa-times'></i> {{ __('Đóng') }}",
                        closeOnClick: true,
                    },
                },
                callback: function($this, type, ev){}
            });
            video_alias = alias;
        }
        $(document).on('click', '#search-playlist', function(){
            var _this = $(this);
            $.ajax({
                url: "{{ route('site.upload.playlist.search') }}",
                dataType: "json",
                data: {
                    'q' : $(this).parent().find('input').val(),
                    'video': video_alias
                },
                success: function(data){
                    var _ele = _this.parent().find('ul');
                    _ele.empty();
                    $.each(data.data, function(key, value){
                        _ele.append('<li><a href="#" data-alias="' + value.alias + '" class="choose-playlist">' + value.title + '</a></li>')
                    })
                    
                }
            })
        })
        $(document).on('click', '.choose-playlist', function(){
            $.ajax({
                url: "{{ route('site.upload.playlist.addto') }}",
                dataType: "json",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    video: video_alias,
                    playlist: $(this).data('alias')
                },
                success: function(data){
                    Lobibox.notify('success', {
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        msg: "{{ __('Thành công thao tác của bạn đã lưu') }}"
                    });
                },
                error: function(response){
                    if (response.status == 409)
                    {
                        Lobibox.notify('error', {
                            size: 'mini',
                            rounded: true,
                            delayIndicator: false,
                            msg: "{{ __('Video đã nằm trong danh sách phát') }}"
                        });
                    }
                }
            })
        })
        function subscribe(element){
            const alias = element.data('user-alias')
            if (alias != user && user){
                $.ajax({
                    url: element.data('user-subscribe-url'),
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
            } else if (!user){
                window.location.href = "{{ route('site.login') }}"
            }
        }
        $.contextMenuCommon({
            selector: '.post.post-video',
            items: {
                subscribe: {
                    label: "{{ __('Đăng kí / Hủy đăng kí') }}",
                    icon: 'fa fa-user',
                    callback: function (){
                        subscribe($(this))
                    }
                },
                addPlaylist: {
                    label: "{{ __('Thêm vào playlist') }}",
                    icon: 'fa fa-heart',
                    callback: function (){
                        if (user){
                            addToPlaylist($(this).data('video-alias'))
                        }
                    }
                },
                copy: {
                    label: "{{ __('Sao chép địa chỉ') }}",
                    callback: function (){
                        var element = $("<input>");
                        $("body").append(element);
                        element.val($(this).find('.post-des > h6 > a').attr('href')).select()
                        document.execCommand("copy")
                        element.remove()
                    }
                }

            }
        });
        @yield('ready-script')
    });
</script>

<script src="{{ asset('site/js/what-input.min.js')}}"></script>
<script src="{{ asset('site/js/foundation.min.js')}}"></script>
<script src="{{ asset('site/js/jquery.showmore.src.js')}}" type="text/javascript"></script>
<script src="{{ asset('site/js/app.js')}}"></script>
<script src="{{ asset('site/js/greensock.js')}}" type="text/javascript"></script>
<!-- LayerSlider script files -->
<script src="{{ asset('site/js/layerslider.transitions.js')}}" type="text/javascript"></script>
<script src="{{ asset('site/js/layerslider.kreaturamedia.jquery.js')}}" type="text/javascript"></script>
<script src="{{ asset('site/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('site/js/inewsticker.js')}}" type="text/javascript"></script>
<script src="{{ asset('site/js/jquery.kyco.easyshare.js')}}" type="text/javascript"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
@auth
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "a62ccc01-a75a-45d5-8b6d-9f63bd8846d8",
        });
        OneSignal.sendTags({!! json_encode(App\Helpers\Content::renderChannelList()) !!})
    });
</script>
@endauth
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119763293-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-119763293-1');
</script>

</body>
</html>