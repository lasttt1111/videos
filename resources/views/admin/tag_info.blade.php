@section('module')
{{ __('Thẻ') }}
@stop
@section('function')
{{ $tag->title }}
@stop
@includeIf('admin/video_index', ['video' => $video])