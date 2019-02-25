@section('module')
{{ __('Bảng điều khiển') }}
@stop
@section('function')
{{ __('Trang chủ') }}
@stop
@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $userCount }}</h3>
                <p>{{ __('Thành viên') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('admin.user.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $videoCount }}</h3>
                <p>{{ __('Video') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-social-youtube"></i>
            </div>
            <a href="{{ route('admin.video.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $playlistCount }}</h3>
                <p>{{ __('Danh sách phát') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-list"></i>
            </div>
            <a href="{{ route('admin.playlist.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@stop