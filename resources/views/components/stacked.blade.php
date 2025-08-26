@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="d-flex flex-column align-items-center">

            {{-- Texto arriba --}}
            @if ($paginator->firstItem())
                <p class="small text-muted mb-2 text-center">
                    {{ __('Showing') }}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {{ __('to') }}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {{ __('of') }}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {{ __('results') }}
                </p>
            @else
                <p class="small text-muted mb-2 text-center">
                    {{ __('Showing') }} {{ $paginator->count() }} {{ __('results') }}
                </p>
            @endif

            {{-- Números abajo --}}
            <ul class="pagination mb-0 mt-2 justify-content-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
