@section('module')
{{ __('Báo cáo') }}
@stop
@section('function')
{{ __('Danh sách') }}
@stop
@section('content')
<table class="table table-hover">
    <caption>{{ __('Danh sách báo cáo') }}</caption>
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Thành viên') }}</th>
            <th>{{ __('Video') }}</th>
            <th>{{ __('Nội dung') }}</th>
            <th>{{ __('IP') }}</th>
            <th>{{ __('Thời gian') }}</th>
            <th>{{ __('Hành động') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
        <tr class="table-menu">
            <td>{{ $report->id }}</td>
            <td>{{ $report->user->name }}</td>
            <td><a href="{{ route('site.watch', ['alias' => $report->video->alias]) }}">{{ $report->video->title }}</a></td>
            <td>{{ str_limit($report->message, 50) }}</td>
            <td>{{ $report->ip }}</td>
            <td>{{ $report->created_at }}</td>
            <td>
                <a href="{{ route('admin.report.info', ['id' => $report->id]) }}" data-action="info">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                </a>
                <a href="{{ route('admin.report.delete', ['id' => $report->id]) }}" data-action="delete">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {!! $reports->links() !!}
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