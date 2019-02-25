@section('module')
{{ __('Thẻ') }}
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
            {{ __('Chỉnh sửa hoàn tất') }}
        </div> 
        @endif
        {{ Form::open(['url' => route('admin.tag.edit', ['alias' => $tag->alias]), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
        <div class="form-group">
            {{ Form::label('alias', __('Định danh')) }}
            {{ Form::text('alias',  $tag->alias , ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('title', __('Tên thẻ')) }}
            {{ Form::text('title', $tag->title, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">{{ __('Hoàn tất') }}</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop