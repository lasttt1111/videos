@section('module')
{{ __('Thành viên') }}
@stop
@section('function')
{{ __('Chỉnh sửa') }}
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
            {{ __('Chỉnh sửa thành công') }}
        </div> 
        @endif
        {{ Form::open(['url' => route('admin.user.edit', ['alias' => $user->alias]), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
        <div class="form-group">
            {{ Form::label('alias', __('Định danh')) }}
            {{ Form::text('alias', $user->alias, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('name', __('Tên')) }}
            {{ Form::text('name', $user->name, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', __('Mật khẩu')) }}
            {{ Form::password('password', ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('permission', __('Quyền hạn')) }}
            {{ Form::select('permission', ['1' => __('Quản trị'), '2' => __('Quản lí'), '3' => __('Thành viên')], $user->permission, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('avatar', __('Ảnh đại diện')) }}
            {{ Form::file('avatar') }}
        </div>
        <div class="form-group">
            {{ Form::label('cover', __('Ảnh bìa')) }}
            {{ Form::file('cover') }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">{{ __('Hoàn tất') }}</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop