@section('module')
{{ __('Nhật kí') }}
@stop
@section('function')
{{ __('Chi tiết') }}
@stop
@section('content')
<table class="table table-hover">
    <tbody>
        <tr>
            <td class="col-md-3">{{ __('#') }}</td>
            <td class="col-md-9">{{ $log->id }}</td>
        </tr>
        <tr>
            <td>{{ __('Mức độ') }}</td>
            <td>{{ __($log->level) }}</td>
        </tr>
    {{--     <tr>
            <td>{{ __('Thành viên') }}</td>
            <td><a href="{{ route('site.user.profile', ['alias' => isset($image->user->alias) ? $image->user->alias : '']) }}">{{ $image->user->name or __('Ai đó') }}</a></td>
        </tr> --}}
        <tr>
            <td>{{ __('Đường dẫn') }}</td>
            <td><a href="{{ $log->url }}">{{ $log->url }}</a></td>
        </tr>
        <tr>
            <td>{{ __('IP') }}</td>
            <td>{{ $log->ip }}</td>
        </tr>
        <tr>
            <td>{{ __('Nội dung') }}</td>
            <td>{{ $log->message }}</td>
        </tr>
        <tr>
            <td>{{ __('Dữ liệu JSON') }}</td>
            <td>{{ $log->data }}</td>
        </tr>
    </tbody>
</table>
<a href="{{ route('admin.log.delete', ['id' => $log->id]) }}"><button class="btn btn-danger">{{ __('Xóa') }}</button></a>
<style type="text/css">
    .table > tbody > tr > td:first-child{
        font-weight: bold;
    }
</style>
@stop
