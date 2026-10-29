@if ($paginator->hasPages())
    <ul class="pager text-center px-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->path() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @php
            $current = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $window = 2; // Mostrar 2 páginas antes y después de la actual
        @endphp

        {{-- Primera página --}}
        @if ($current > ($window + 2))
            <li><a href="{{ $paginator->url(1) }}">1</a></li>
        @endif

        {{-- Puntos suspensivos antes --}}
        @if ($current > ($window + 3))
            <li class="disabled"><span>...</span></li>
        @endif

        {{-- Páginas alrededor de la actual --}}
        @for ($i = max(1, $current - $window); $i <= min($lastPage, $current + $window); $i++)
            @if ($i == $current)
                <li class="active my-active"><span>{{ $i }}</span></li>
            @else
                <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @endif
        @endfor

        {{-- Puntos suspensivos después --}}
        @if ($current < ($lastPage - $window - 2))
            <li class="disabled"><span>...</span></li>
        @endif

        {{-- Última página --}}
        @if ($current < ($lastPage - $window - 1))
            <li><a href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
