@section('module')
{{ __('Ngôn ngữ') }}
@stop
@section('function')
{{ __('Danh sách') }}
@stop
@section('content')
<table class="table table-hover">
    <caption>{{ __('Danh sách ngôn ngữ') }}</caption>
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Tên ngôn ngữ') }}</th>
            <th>{{ __('Ngày cập nhật') }}</th>
            <th>{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($languages as $key => $language)
        <tr data-alias="{{ $language->id }}" class="table-menu">
            <td>{{ $language->id }}</td>
            <td>{{ $language->name }}</td>
            <td>{{ $language->created_at }}</td>
            <td>
                <a href="{{ route('admin.language.info', ['alias' => $language->id]) }}" data-action="info">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>
                </a>
                <a href="{{ route('admin.language.download', ['alias' => $language->id]) }}" data-action="download">
                    <button class="btn btn-sm btn-default"><i class="fa fa-cloud-download" aria-hidden="true"></i></i></button>
                </a>
                <a href="{{ route('admin.language.edit', ['alias' => $language->id]) }}" data-action="edit">
                    <button class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                </a>
                <a href="{{ route('admin.language.delete', ['alias' => $language->id]) }}" data-action="delete">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {!! $languages->links() !!}
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
            name: "{{ __('Chỉnh sửa cụm từ') }}",
            icon: "fa-eye",
            callback: function(key, element){
                $('.table-menu').trigger('contextmenu:hide');
                window.location.href = $(this).find('td > a[data-action="info"]').attr('href');
            },
        },
        download: {
            name: "{{ __('Tải xuống file json') }}",
            icon: "fa-cloud-download",
            callback: function(key, element){
                $('.table-menu').trigger('contextmenu:hide');
                window.location.href = $(this).find('td > a[data-action="download"]').attr('href');
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