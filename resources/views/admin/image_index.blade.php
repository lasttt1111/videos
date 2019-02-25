@section('module')
{{ __('Hình ảnh') }}
@stop
@section('function')
{{ __('Danh sách') }}
@stop
@section('content')
<table class="table table-hover">
    <caption>{{ __('Danh sách nhật kí') }}</caption>
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Ảnh') }}</th>
            <th>{{ __('Thành viên') }}</th>
            <th>{{ __('Thời gian') }}</th>
            <th>{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($images as $image)
        <tr data-alias="{{ $image->alias }}" class="table-menu">
            <td>{{ $image->id }}</td>
            <td><img src="{{ $image->link }}" style="max-width: 50px; max-height: 50px;"></td>
            <td>{{ $image->user->name }}</td>
            <td>{{ $image->created_at }}</td>
            <td>
                <a href="{{ route('admin.image.info', ['id' => $image->id]) }}" data-action="info">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                </a>
                <a href="{{ route('admin.image.delete', ['id' => $image->id]) }}" data-action="delete">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {!! $images->links() !!}
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
            name: "{{ __('Xem') }}",
            icon: "fa-eye",
            callback: function(key, element){
                $('.table-menu').trigger('contextmenu:hide');
                window.location.href = $(this).find('td > a[data-action="info"]').attr('href');
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