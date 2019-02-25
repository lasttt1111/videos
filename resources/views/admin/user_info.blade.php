@section('module')
{{ __('Thành viên') }}
@stop
@section('function')
{{ $user->name }}
@stop
@includeIf('admin/video_index', ['video' => $video])