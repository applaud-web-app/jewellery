@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())
    <a class="pagi-btn" style="background:gray;opacity:0.7;">Prev</a>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="pagi-btn">Prev</a>
    @endif
    <ul>
        @foreach ($elements as $element)
           @if (is_string($element))
           <li><a href="#">1</a></li>
           @endif
           @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active"><a>{{ $page }}</a></li>
                @else
                    <li class="page-item"><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
           @endif
        @endforeach
    </ul>
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="pagi-btn">Next</a>
    @else
    <a class="pagi-btn" style="background:gray;opacity:0.7;">Next</a>
    @endif
@endif