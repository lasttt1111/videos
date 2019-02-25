@section('module')
{{ __('Danh mục') }}
@stop
@section('function')
{{ __('Thêm mới') }}
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
        @elseif(isset($success))
        <div class="alert alert-success">
            {{ __('Thêm mới hoàn tất') }}
        </div> 
        @endif
        {{ Form::open(['url' => route('admin.category.add'), 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        <div class="form-group">
            {{ Form::label('alias', __('Định danh')) }}
            {{ Form::text('alias',  null , ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('title', __('Tên danh mục')) }}
            {{ Form::text('title', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('image', __('Ảnh đại diện')) }}
            {{ Form::file('image') }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">{{ __('Hoàn tất') }}</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop