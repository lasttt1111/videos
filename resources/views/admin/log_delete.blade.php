@section('module')
{{ __('Nhật ký') }}
@stop
@section('function')
{{ __('Xóa nhật ký') }}
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
            {{ Form::open(['url' => route('admin.log.delete', ['id' => $log->id]), 'method' => 'delete']) }}
                <p>{{ __('Bạn có muốn xóa nhật ký :log không?', ['log' => $log->title]) }}</p>
                <button type="submit" class="btn btn-danger">{{ __('Xóa ngay') }}</button>
                <a href="{{ route('admin.log.index') }}"><button type="button" class="btn btn-default">{{ __('Hủy bỏ') }}</button></a>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop