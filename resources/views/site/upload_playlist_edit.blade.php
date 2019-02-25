@section('content')
<div class="profile-inner">
    <section class="submit-post">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="heading">
                    <i class="fa fa-pencil-square-o"></i>
                    <h4>{{ __('Chỉnh sửa danh sách phát') }}</h4>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        {{Form::open(['url' => route('site.upload.playlist.edit', ['alias' => $playlist->alias]), 'enctype' => 'multipart/form-data', 'id' => 'edit-playlist', 'method' => 'put'])}}
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
                        @endif
                        <div class="row">
                            <div class="large-12 columns">
                                <label>{{ __('Tên danh sách phát') }}
                                    {{ Form::text('title', $playlist->title, ['placeholder' => __('Tên danh sách phát')]) }}
                                </label>
                                <label>{{ __('Quyền riêng tư') }}
                                    {{ Form::select('privacy', [__('Công khai'), __('Không công khai'), __('Riêng tư')], $playlist->privacy) }}
                                </label>
                                <div class="upload-video">
                                    <label for="imgUpload" class="button">{{ __('Chọn ảnh đại diện') }}</label>
                                    <input type="file" name="image" class="show-for-sr" id="imgUpload">
                                    <span>{{ __('Chưa chọn file') }}</span>
                                </div>
                                <div class="columns large-12">
                                    <label>{{ __('Danh sách video') }}</label>
                                    <p>{{ __('Bạn hãy kéo thả để sắp xếp lại vị trí') }}</p>
                                    <button type="button" id="add-video"><i class="fa fa-plus"></i>{{ __('Thêm video') }}</button>
                                    <hr />
                                    <div class="media-object stack-for-small" id="sortable">
                                        @foreach ($playlist->video as $k => $video)
                                        <div class="columns large-12" data-id="{{ $video->id }}">
                                            <div class="columns large-3">
                                                <img src="{{ $video->image }}" width="100%">
                                            </div>
                                            <div class="columns large-9">
                                                <h6><a href="{{ route('site.watch', ['alias' => $video->alias]) }}">{{ $video->title }}</a></h6>
                                                <p>{{ $video->user->name or __('Ai đó') }}</p>
                                                <button class="pull-right delete-video" type="button">{{ __('Xóa') }}</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="video" value="">
                                <hr />
                                <div class="columns large-12">
                                    {!! Recaptcha::render() !!}
                                </div>
                            </div>
                            <div class="large-12 columns">
                                <button class="button expanded" type="submit" name="submit">{{ __('Chỉnh sửa') }}</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div style="display: none;">
    <div id="edit-playlist-modal">
        <label>{{ __('Tên playlist') }}
            <input type="text" name="video-name" placeholder="{{ __('Tìm video') }}">
        </label>
        <button type="button" class="button" id="search-video">{{ __('Tìm kiếm') }}</button>
        <ul class="result"></ul>
    </div>
</div>
@stop
@section('beforeEnd')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
@stop
@section('ready-script')
$("#imgUpload").change(function(e){
    if (e.target.files && e.target.files[0].name){
        $(this).parent().find('span').html(e.target.files[0].name);
    }
})
$("#sortable").sortable();
$(document).on('submit', '#edit-playlist', function(){
    var str = '';
    $('#sortable > div').each(function(){
        str += $(this).data('id').trim() + ',';
    })
    str = str.slice(0, -1);
    $('input[name="video"]').val(str);
    return true;
})
$(document).on('click', '.delete-video', function(){
    $(this).parent().parent().remove();
})
$("#add-video").click(function(){
    Lobibox.window({
        title: "{{ __('Thêm vào playlist') }}",
        closeButton: true,
        draggable: true,
        content: $('#edit-playlist-modal'),
        width: jQuery(document).width() * 60 / 100,
        buttons: {
            close: {
                text: "<i class='fa fa-times'></i> {{ __('Đóng') }}",
                closeOnClick: true,
            },
        },
        callback: function($this, type, ev){}
    });
})
$(document).on('click', '#search-video', function(e){
    var _this = $(this);
    $.ajax({
        url: "{{ route('site.upload.playlist.search') }}",
        dataType: "json",
        data: {
            playlist: "{{ $playlist->alias }}",
            q: $(this).parent().find('input').val()
        },
        success: function(data){
            _this.parent().find('.result').empty();
            $.each(data.data, function(k, value){
                _this.parent().find('.result').append('<li><a href="#" data-id="' + value.id + '" class="choose-video" data-title="' + value.title + '" data-image="' + value.image + '">' + value.title + '</a></li>');
            })
        }
    })
})
$(document).on('click', '.choose-video', function(e){
    $(this).parent().remove();
    $('#sortable').append('<div class="columns large-12" data-id=" ' + $(this).data('id') + '"><div class="columns large-3"><img src="' + $(this).data('image') + '" width="100%"></div><div class="columns large-9"><h6><a href="#">' + $(this).data('title') + '</a></h6><p></p><button class="pull-right delete-video" type="button">{{ __('Xóa') }}</button></div></div>');
})
@stop