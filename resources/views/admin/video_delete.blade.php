@section('module')
{{ __('Video') }}
@stop
@section('function')
{{ __('Xóa video') }}
@stop
@section('content')
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">{{ __('Thông tin cơ bản') }}</h3>
    </div>
    <div class="box-body">
        @if ($errors->count() > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> 
        @endif
        <div class="alert alert-warning">
            {{ Form::open(['url' => route('admin.video.delete', ['alias' => $video->alias]), 'method' => 'delete']) }}
                <p>{{ __('Bạn có muốn xóa video :title không?', ['title' => $video->title]) }}</p>
                <button type="submit" class="btn btn-danger">{{ __('Xóa ngay') }}</button>
                <a href="{{ route('admin.video.index') }}"><button type="button" class="btn btn-default">{{ __('Hủy bỏ') }}</button></a>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop