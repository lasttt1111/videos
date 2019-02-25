@section('module')
{{ __('Danh sách phát') }}
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
        {{ Form::open(['url' => route('admin.playlist.edit', ['alias' => $playlist->alias]), 
            'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'playlist-edit'
            ]) }}
        <div class="form-group">
            {{ Form::label('user_alias', __('Định danh chủ sở hữu')) }}
            {{ Form::text('user_alias', isset($playlist->user->alias) ? $playlist->user->alias : '', ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('alias', __('Định danh')) }}
            {{ Form::text('alias', $playlist->alias, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('title', __('Tên playlist')) }}
            {{ Form::text('title', $playlist->title, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('privacy', __('Quyền riêng tư')) }}
            {{ Form::select('privacy', [__('Công khai'), __('Không công khai'), __('Riêng tư')], $playlist->privacy, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('image', __('Ảnh đại diện')) }}
            {{ Form::file('image') }}
        </div>
        <div class="">
            <label>{{ __('Danh sách video') }}</label>
            <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-video">
                <i class="fa fa-plus"></i>
            </button>
            <ul class="products-list product-list-in-box" id="sortable">
                @foreach ($playlist->video as $video)
                <li class="item" data-id="{{ $video->id }}" data-alias="{{ $video->alias }}">
                    <div class="product-img">
                        <img src="{{ $video->image }}" alt="{{ $video->title }}">
                    </div>
                    <div class="product-info">
                        <a href="{{ route('admin.video.edit', ['alias' => $video->alias]) }}" class="product-title">{{ $video->title }}</a>
                        <button class="btn btn-xs btn-danger pull-right delete-video" type="button">{{ __('Xóa') }}</button>
                        <span class="product-description">{{ $video->user->name }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
            <input type="hidden" name="video" id="position">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success submit-edit">{{ __('Hoàn tất') }}</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
<div class="modal fade" id="modal-video">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ __('Thêm video mới') }}</h4>
            </div>
            <div class="modal-body">
                <label>{{ __('Tìm kiếm') }}
                    <input class="form-control" type="text">
                </label>
                <button type="button" class="btn btn-primary search-video">{{ __('Tìm kiếm') }}</button>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="products-list product-list-in-box" id="result"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('Đóng') }}</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('ready-script')
$("#sortable").sortable();
$('#playlist-edit').submit(function(){
    var value = '';
    $('#sortable > .item').each(function(){
        value += $(this).data('id') + ','
    })
    value = value.slice(0, -1);
    $("#position").val(value)
    return true;
})
$(document).on('click', 'button.delete-video', function(){
    var _p = $(this).parent().parent();
    _p.remove();
})
function addItem(selector, data)
{
    selector.append('<li class="item" data-id="' + data.id + '" data-alias="' + data.alias + '"><div class="product-img"><img src="' + (data.image ? data.image : 'https://placehold.it/50x50') + '" alt="'+ data.title +'"></div><div class="product-info"><a href="#" class="product-title">'+ data.title +'</a><button class="btn btn-xs btn-success pull-right add-video" type="button">{{ __('Thêm') }}</button><span class="product-description">' + (data.user && data.user.name ? data.user.name : '{{ __('Ai đó') }}') + '</span></div></li>')
}
$('.search-video').click(function(){
    $.ajax({
        url: "{{ route('admin.playlist.search') }}",
        method: "get",
        dataType: "json",
        data: {
            q: $(this).parent().find('label > input').val()
        },
        success: function(data){
            $("#result").empty()
            $.each(data.data, function(key, value){
                addItem($("#result"), value)
            })
        }
    })
})
$(document).on('click', '.add-video', function(){
    var _this = $(this);
    _this.removeClass('btn-success add-video').addClass('btn-danger delete-video')
    _this.html('{{ __('Xóa') }}')
    var _parent = _this.parent().parent();
    _parent.clone().appendTo("#sortable");
    _parent.remove();
    $("#sortable").sortable();
})
@stop