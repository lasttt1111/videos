@php \App\Helpers\Content::setData('user_menu', 'info'); @endphp
@section ('user_content')
<section class="profile-settings">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="heading">
                <i class="fa fa-gears"></i>
                <h4>{{ __('Thông tin cá nhân') }}</h4>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    @if ($errors->count() > 0)
                    <div data-abide-error="" class="alert callout">
                        <p><i class="fa fa-exclamation-triangle"></i> {{ __('Có lỗi xảy ra') }}
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </p>
                    </div>
                    @elseif (isset($success))
                    <div data-abide-error="" class="callout success">
                        <p>{{ __('Thành công, đã lưu') }}</p>
                    </div>
                    @endif
                    <div class="setting-form">
                        {{ Form::open(['url' => route('site.user.info', ['alias' => $user->alias]), 'method' => 'put', 'enctype' => 'multipart/form-data']) }}
                        <div class="setting-form-inner">
                            <div class="row">
                                <div class="large-12 columns">
                                    <h6 class="borderBottom">{{ __('Chung') }}</h6>
                                </div>
                                <div class="medium-12 columns">
                                    <label>{{ __('Tên') }}
                                        <input type="text" placeholder="{{ __('Tên hiển thị') }}" required="required" min="6" max="150" value="{{ $user->name }}" name="name">
                                    </label>
                                </div>
                                <div class="medium-12 columns">
                                    <label>{{ __('Mật khẩu') }}
                                        <input type="password" placeholder="{{ __('Mật khẩu') }}" value="" name="password">
                                    </label>
                                </div>
                                <div class="medium-12 columns">
                                    <label>{{ __('Mật khẩu xác nhận') }}
                                        <input type="password" placeholder="{{ __('Mật khẩu xác nhận') }}" value="" name="password_confirmation">
                                    </label>
                                </div>
                                <div class="medium-12 columns">
                                    <label>{{ __('Ảnh đại diện') }}
                                        {{ Form::file('avatar') }}
                                    </label>
                                </div>
                                <div class="medium-12 columns">
                                    <label>{{ __('Ảnh bìa') }}
                                        {{ Form::file('cover') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setting-form-inner">
                            <button class="button expanded" type="submit" name="setting">{{ __('Cập nhật') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@includeIf('site/user_template')