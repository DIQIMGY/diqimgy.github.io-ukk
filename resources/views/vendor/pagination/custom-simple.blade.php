@if ($paginator->hasPages())
    <nav>
        <ul class="pagination" style="display:flex;gap:6px;padding:0;margin:0;list-style:none">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="padding:8px 12px;font-size:0.85rem;border-radius:10px;border:1px solid #e0e0e0;background:#f5f5f5;color:#999;display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;cursor:not-allowed">‹</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding:8px 12px;font-size:0.85rem;border-radius:10px;border:1px solid #e0e0e0;background:#fff;color:#333;display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;text-decoration:none;transition:all 0.2s">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="padding:8px 12px;font-size:0.85rem;border-radius:10px;border:1px solid #e0e0e0;background:#fff;color:#999;display:flex;align-items:center;justify-content:center;min-width:36px;height:36px">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link" style="padding:8px 12px;font-size:0.85rem;border-radius:10px;border:none;background:#ed1b3b;color:#fff;display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;font-weight:700;box-shadow:0 4px 12px rgba(237,27,59,0.3)">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}" style="padding:8px 12px;font-size:0.85rem;border-radius:10px;border:1px solid #e0e0e0;background:#fff;color:#333;display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;text-decoration:none;transition:all 0.2s">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding:8px 12px;font-size:0.85rem;border-radius:10px;border:1px solid #e0e0e0;background:#fff;color:#333;display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;text-decoration:none;transition:all 0.2s">›</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="padding:8px 12px;font-size:0.85rem;border-radius:10px;border:1px solid #e0e0e0;background:#f5f5f5;color:#999;display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;cursor:not-allowed">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
