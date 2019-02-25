@section('module')
{{ __('Hình ảnh') }}
@stop
@section('function')
{{ __('Chi tiết') }}
@stop
@section('content')
<table class="table table-hover">
    <tbody>
        <tr>
            <td class="col-md-3">{{ __('#') }}</td>
            <td class="col-md-9">{{ $image->id }}</td>
        </tr>
        <tr>
            <td>{{ __('Thành viên') }}</td>
            <td><a href="{{ route('site.user.profile', ['alias' => isset($image->user->alias) ? $image->user->alias : '']) }}">{{ $image->user->name or __('Ai đó') }}</a></td>
        </tr>
        <tr>
            <td>{{ __('Ảnh') }}</td>
            <td><img src="{{ $image->link }}" style="max-height: 50px; max-width: 50px;"></td></td>
        </tr>
        <tr>
            <td>{{ __('Mã xóa') }}</td>
            <td>{{ $image->deletehash }}</td>
        </tr>
        <tr>
            <td>{{ __('Dữ liệu JSON') }}</td>
            <td>{!! nl2br(json_encode(json_decode($image->api, true), JSON_PRETTY_PRINT)) !!}</td>
        </tr>
    </tbody>
</table>
<a href="{{ route('admin.image.delete', ['id' => $image->id]) }}"><button class="btn btn-danger">{{ __('Xóa') }}</button></a>
<style type="text/css">
    .table > tbody > tr > td:first-child{
        font-weight: bold;
    }
</style>
@stop
