@if ($paginator->lastPage() > 1)
<div class="pagination">
    <a href="{{ ($paginator->currentPage() == 1) ? 'javascript:void(0)' : $paginator->url($paginator->currentPage() - 1) }}" class="prev page-numbers">« {{ __('Trở về') }}</a>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        @if ($paginator->currentPage() == $i)
            <span class="page-numbers current">{{ $i }}</span>
        @else
            <a href="{{ $paginator->url($i) }}" class="page-numbers">{{ $i }}</a>
        @endif
    
    @endfor
    <a href="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'javascript:void(0)' : $paginator->url($paginator->currentPage()+1) }}" class="next page-numbers">{{ __('Kế tiếp') }} »</a>
</div>
@endif