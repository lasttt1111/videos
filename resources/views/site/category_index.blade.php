@section('content')
<section class="content content-with-sidebar">
    <div class="main-heading removeMargin">
        <div class="row secBg padding-14 removeBorderBottom">
            <div class="medium-12 small-12 columns">
                <div class="head-title">
                    <i class="fa fa-film"></i>
                    <h4>{{ __('Tất cả danh mục') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="row column head-text clearfix">
                <p class="pull-left">{{ __('Tổng danh mục :number', ['number' => $categories->total()]) }}</p>
            </div>
            <div class="tabs-content" data-tabs-content="newVideos">
                <div class="tabs-panel is-active" id="new-all" role="tabpanel" aria-hidden="false" aria-labelledby="new-all-label">
                    <div class="row list-group">
                        @foreach ($categories as $k => $category)
                        <div class="item large-4 medium-6 columns grid-medium">
                            <div class="post thumb-border">
                                <div class="post-thumb">
                                    <img src="{{ $category->image }}" alt="new video">
                                    <a href="{{ route('site.category.category', ['alias' => $category->alias]) }}" class="hover-posts">
                                        <span><i class="fa fa-play"></i>{{ __('Xem danh mục') }}</span>
                                    </a>
                                </div>
                                <div class="post-des">
                                    <h6><a href="{{ route('site.category.category', ['alias' => $category->alias]) }}">{{ $category->title }}</a></h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @includeIf('site/pagination', ['paginator' => $categories])
        </div>
    </div>
</section>
@stop