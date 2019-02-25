@section('module')
{{ __('Nhật kí') }}
@stop
@section('function')
{{ __('Danh sách') }}
@stop
@section('content')
{{ Form::open(['url' => route('admin.log.index'), 'method' => 'get', 'class' => 'form-inline']) }}
{{ Form::text('q', null, ['class' => 'form-control', 'placeholder' => __('Từ khóa')]) }}
{{ Form::select('level', $levels, null, ['class' => 'form-control', 'placeholder' => __('Mức độ')]) }}
<button type="submit" class="btn btn-success">{{ __('Tìm kiếm') }}</button>
{{ Form::close() }}
<table class="table table-hover">
    <caption>{{ __('Danh sách nhật kí') }}</caption>
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Thành viên') }}</th>
            <th>{{ __('Nội dung') }}</th>
            <th>{{ __('IP') }}</th>
            <th>{{ __('Thời gian') }}</th>
            <th>{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
        <tr data-alias="{{ $log->alias }}" class="table-menu">
            <td>{{ $log->id }}</td>
            <td>{{ $log->user['name'] }}</td>
            <td>{{ str_limit($log->message, 50) }}</td>
            <td>{{ $log->ip }}</td>
            <td>{{ $log->created_at }}</td>
            <td>
                <a href="{{ route('admin.log.info', ['id' => $log->id]) }}" data-action="info">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                </a>
                <a href="{{ route('admin.log.delete', ['id' => $log->id]) }}" data-action="delete">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {!! $logs->links() !!}
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