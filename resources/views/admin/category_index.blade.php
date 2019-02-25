@section('module')
{{ __('Danh mục') }}
@stop
@section('function')
{{ __('Danh sách') }}
@stop
@section('content')
<table class="table table-hover">
    <caption>{{ __('Danh sách danh mục') }}</caption>
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Tên danh mục') }}</th>
            <th>{{ __('Số video') }}</th>
            <th>{{ __('Ngày tạo') }}</th>
            <th>{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr class="table-menu">
            <td>{{ $category->id }}</td>
            <td>{{ $category->title }}</td>
            <td>{{ $category->video_count }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <a href="{{ route('admin.category.info', ['alias' => $category->alias]) }}" data-action="info">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                </a>
                <a href="{{ route('admin.category.edit', ['alias' => $category->alias]) }}" data-action="edit">
                    <button class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                </a>
                <a href="{{ route('admin.category.delete', ['alias' => $category->alias]) }}" data-action="delete">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {!! $categories->links() !!}
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