@section('module')
{{ __('Báo cáo') }}
@stop
@section('function')
{{ __('Chi tiết') }}
@stop
@section('content')
<table class="table table-hover">
    <tbody>
        <tr>
            <td class="col-md-3">{{ __('#') }}</td>
            <td class="col-md-9">{{ $report->id }}</td>
        </tr>
        <tr>
            <td>{{ __('Thành viên') }}</td>
            <td><a href="{{ route('site.user.profile', [ 'alias' => $report->user->alias ]) }}">{{ $report->user->name }}</a></td>
        </tr>
        <tr>
            <td>{{ __('Video') }}</td>
            <td><a href="{{ route('site.watch', ['alias' => $report->video->alias]) }}">{{ $report->video->title }}</a></td>
        </tr>
        <tr>
            <td>{{ __('IP') }}</td>
            <td>{{ $report->ip }}</td>
        </tr>
        <tr>
            <td>{{ __('Nội dung') }}</td>
            <td>{{ $report->message }}</td>
        </tr>
    </tbody>
</table>
<a href="{{ route('admin.report.delete', ['id' => $report->id]) }}"><button class="btn btn-danger">{{ __('Xóa') }}</button></a>
<style type="text/css">
    .table > tbody > tr > td:first-child{
        font-weight: bold;
    }
</style>
@stop
