@section('module')
{{ __('Video') }}
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
        {{ Form::open(['url' => route('admin.video.edit', ['alias' => $video->alias]), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
        <div class="form-group">
            {{ Form::label('user_alias', __('Định danh chủ sở hữu')) }}
            {{ Form::text('user_alias', isset($video->user->alias) ? $video->user->alias : '', ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('alias', __('Định danh')) }}
            {{ Form::text('alias', $video->alias, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('title', __('Tên video')) }}
            {{ Form::text('title', $video->title, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('description', __('Mô tả')) }}
            {{ Form::textarea('description', $video->description, ['class' => 'form-control']) }}
        </div>
        {{-- <div class="form-group">
            {{ Form::label('link', __('Liên kết')) }}
            {{ Form::textarea('link', \App\Helpers\GetLink::getSavedLinks($video->link), ['class' => 'form-control']) }}
        </div> --}}
        <div class="form-group">
            {{ Form::label('privacy', __('Quyền riêng tư')) }}
            {{ Form::select('privacy', [__('Công khai'), __('Không công khai'), __('Riêng tư')], $video->privacy, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('image', __('Ảnh đại diện')) }}
            {{ Form::file('image') }}
        </div>
        <div class="form-group">
            {{ Form::label('category', __('Danh mục')) }}
            {{ Form::select('category', $categories, $video->category_id, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('tags[]', __('Thẻ')) }}
            {{ Form::select('tags[]', $tags, $video->tags->pluck('id')->all(), ['class' => 'form-control', 'multiple' => 'multiple']) }}
        </div>
        <div class="form-group">
            {{ Form::label('label', __('Nhãn')) }}
            {{ Form::text('label', $video->label, ['class' => 'form-control']) }}
        </div>
        <div class="form-group" hidden>
            {{ Form::label('language', __('Ngôn ngữ')) }}
            {{ Form::select('language', $languages, $video->language, ['class' => 'form-control']) }}
        </div>
        <div class="form-group" hidden>
            {{ Form::label('price', __('Giá tiền')) }}
            {{ Form::number('price', $video->price, ['class' => 'form-control', 'min' => 0]) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', __('Mật khẩu')) }}
            {{ Form::password('password', ['class' => 'form-control']) }}
            @if ($video->has_password)
            <label>{{ Form::checkbox('remove-password', 1) }} {{ __('Hủy bỏ mật khẩu') }}</label>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">{{ __('Hoàn tất') }}</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop