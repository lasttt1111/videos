@section('module')
{{ __('Danh mục') }}
@stop
@section('function')
{{ $category->title }}
@stop
@includeIf('admin/video_index', ['video' => $video])