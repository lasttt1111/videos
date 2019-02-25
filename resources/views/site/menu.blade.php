<div class="off-canvas position-left light-off-menu" id="offCanvas" data-off-canvas>
    <div class="off-menu-close">
        <h3>{{ __('Menu') }}</h3>
        <span data-toggle="offCanvas"><i class="fa fa-times"></i></span>
    </div>
    <ul class="vertical menu off-menu" data-responsive-menu="drilldown">
        <li><a href="{{ route('site.index') }}"><i class="fa fa-home"></i>{{ __('Trang chủ') }}</a></li>
        <li><a href="{{ route('site.video') }}"><i class="fa fa-film"></i>{{ __('Video') }}</a></li>
        <li><a href="{{ route('site.category.index') }}"><i class="fa fa-th"></i>{{ __('Danh mục') }}</a></li>
        <li><a href="{{ route('site.playlist.index') }}"><i class="fa fa-list-ul" aria-hidden="true"></i>{{ __('Danh sách phát') }}</a></li>
        @if (Auth::check())
        <li>
            <a href="#"><i class="fa fa-edit"></i>{{ __('Tài khoản') }}</a>
            <ul class="submenu menu vertical" data-submenu data-animate="slide-in-down slide-out-up">
                <li>
                    <a href="{{ route('site.user.profile', ['alias' => Auth::user()->alias]) }}">
                        <i class="fa fa-edit"></i>{{ __('Trang cá nhân') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('site.user.profile', ['alias' => Auth::user()->alias]) }}">
                        <i class="fa fa-play" aria-hidden="true"></i>{{ __('Quản lí video') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('site.user.playlist', ['alias' => Auth::user()->alias]) }}">
                        <i class="fa fa-headphones" aria-hidden="true"></i>{{ __('Quản lí danh sách phát') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('site.upload.playlist.add') }}">
                        <i class="fa fa-plus"></i>{{ __('Thêm mới danh sách phát') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('site.logout') }}">
                        <i class="fa fa-sign-out"></i>{{ __('Đăng xuất') }}
                    </a>
                </li>
            </ul>
        </li>
        @if (Auth::user()->permission < 3)
        <li><a href="{{ route('admin.index') }}"><i class="fa fa-user"></i>{{ __('Trang quản trị') }}</a></li>
        @endif
        @endif
<!--         <li>
            <a href="#"><i class="fa fa-language"></i>{{ __('Ngôn ngữ') }}</a>
            <ul class="submenu menu vertical" data-submenu data-animate="slide-in-down slide-out-up">
                @foreach (\App\Helpers\Content::getLanguages() as $lang)
                <li>
                    <a href="{{ route('site.language', ['id' => $lang->id]) }}">
                        <i class="fa fa-language"></i>{{ $lang->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </li> -->
    </ul>
    <div class="responsive-search">
        <form method="get" action="{{ route('site.search') }}">
            <div class="input-group">
                <input name="q" class="input-group-field" type="text" placeholder="{{ __('Tìm kiếm') }}" value="{{ \Request::get('q', '') }}">
                <div class="input-group-button">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="top-button">
        <ul class="menu">
            @if (Auth::check())
            <li>
                <a href="{{ route('site.upload.video.add') }}">{{ __('Thêm mới video') }}</a>
            </li>
            @else
            <li class="dropdown-login">
                <a href="{{ route('site.login') }}">{{ __('Đăng nhập / đăng kí') }}</a>
            </li>
            @endif
        </ul>
    </div>
</div>