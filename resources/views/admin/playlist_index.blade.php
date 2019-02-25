@section('module')
{{ __('Danh sách phát') }}
@stop
@section('function')
{{ __('Danh sách') }}
@stop
@section('content')
<table class="table table-hover table-bordered">
    <caption>{{ __('Danh sách playlist') }}</caption>
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Tên playlist') }}</th>
            <th>{{ __('Số video') }}</th>
            <th>{{ __('Người tạo') }}</th>
            <th>{{ __('Ngày tạo') }}</th>
            <th>{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($playlists as $playlist)
        <tr data-alias="{{ $playlist->alias }}" class="table-menu">
            <td>{{ $playlist->id }}</td>
            <td>{{ $playlist->title }}</td>
            <td>{{ $playlist->video_count }}</td>
            <td>{{ $playlist->user->name }}</td>
            <td>{{ $playlist->created_at }}</td>
            <td>
                <a href="{{ route('admin.playlist.edit', ['alias' => $playlist->alias]) }}" data-action="edit">
                    <button class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                </a>
                <a href="{{ route('admin.playlist.delete', ['alias' => $playlist->alias]) }}" data-action="delete">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {!! $playlists->links() !!}
</div>
@stop
@section('js-file')
<script type="text/javascript" src="{{ asset('admin/js/jquery.ui.position.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/jquery.contextMenu.min.js') }}"></script>
@stop
@section('css-file')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/jquery.contextMenu.min.css') }}">
@stop
@section('ready-script')
$.contextMenu({
    selector: ".table-menu",
    items: {
        edit: {
            name: "{{ __('Sửa') }}",
            icon: "fa-pencil",
            callback: function(key, element){
                $('.table-menu').trigger('contextmenu:hide');
                window.location.href = $(this).find('td > a[data-action="edit"]').attr('href');
            },
        },
        delete: {
            name: "{{ __('Xóa') }}",
            icon: "fa-trash",
            callback: function(key, element){
                $('.table-menu').trigger('contextmenu:hide');
                window.location.href = $(this).find('td > a[data-action="delete"]').attr('href');
            },
        },
        hide: {
            name: "{{ __('Ẩn') }}",
            icon: "fa-eye-slash",
            callback: function(key, element){
                $('.table-menu').trigger('contextmenu:hide');
                $(this).hide();
            },
        }
    }
});
@stop