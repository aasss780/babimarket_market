@if ($paginator->hasPages())
    <nav class="bm-pagination" role="navigation" aria-label="Pagination">
        <ul class="bm-pagination__list">
            @if ($paginator->onFirstPage())
                <li><span class="bm-pagination__item bm-pagination__item--disabled" aria-disabled="true">&lsaquo;</span></li>
            @else
                <li><a class="bm-pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">&lsaquo;</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="bm-pagination__item bm-pagination__item--dots">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="bm-pagination__item bm-pagination__item--current" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="bm-pagination__item" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="bm-pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">&rsaquo;</a></li>
            @else
                <li><span class="bm-pagination__item bm-pagination__item--disabled" aria-disabled="true">&rsaquo;</span></li>
            @endif
        </ul>
        <p class="bm-pagination__meta">
            @if ($paginator->firstItem())
                Showing <strong>{{ $paginator->firstItem() }}</strong> to <strong>{{ $paginator->lastItem() }}</strong> of <strong>{{ $paginator->total() }}</strong> results
            @else
                <strong>{{ $paginator->count() }}</strong> results
            @endif
        </p>
    </nav>
@endif
