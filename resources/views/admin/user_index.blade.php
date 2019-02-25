@section('module')
{{ __('Thành viên') }}
@stop
@section('function')
{{ __('Danh sách') }}
@stop
@section('content')
<table class="table table-hover">
    <caption>{{ __('Danh sách thành viên') }}</caption>
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Tên thành viên') }}</th>
            <th>{{ __('Số người đăng ký') }}</th>
            <th>{{ __('Số video') }}</th>
            <th>{{ __('Số danh sách phát') }}</th>
            <th>{{ __('Ngày tham gia') }}</th>
            <th>{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr data-alias="{{ $user->alias }}" class="table-menu">
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->subscribers()->count() }}</td>
            <td>{{ $user->video_count }}</td>
            <td>{{ $user->playlist_count }}</td>
            <td>{{ $user->created_at }}</td>
            <td>
                <a href="{{ route('admin.user.info', ['alias' => $user->alias]) }}" data-action="info">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                </a>
                <a href="{{ route('admin.user.edit', ['alias' => $user->alias]) }}" data-action="edit">
                    <button class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                </a>
                <a href="{{ route('admin.user.delete', ['alias' => $user->alias]) }}" data-action="delete">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {!! $users->links() !!}
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
        info: {
            name: "{{ __('Chi tiết') }}",
            icon: "fa-eye",
            callback: function(key, element){
                $('.table-menu').trigger('contextmenu:hide');
                window.location.href = $(this).find('td > a[data-action="info"]').attr('href');
            },
        },
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