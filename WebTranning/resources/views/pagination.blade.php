<div class="row">
    <div class="col ">
        @if ($paginator->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination" style="
    margin-left: 500px;
">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <li class="disabled page-item" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <li class="active page-item" aria-current="page"><span class="page-link">{{ $page }}</span></li>
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
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                </li>
                @else
                <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
                <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
                @endif

            </ul>
        </nav>
        @endif
    </div>
    <div class="col-3" style="margin-top: 10px;">
        <p class="text-sm text-gray-700 leading-5">
        
            Hiện thị từ
            <span class="font-medium">{{$paginator->total()>0?$paginator->currentPage()==$paginator->lastPage()?($paginator->total()-$paginator->count())+1:((($paginator->currentPage() - 1) * $paginator->count())+1):"0"}}</span>
            ~
            <span class="font-medium">{{($paginator->currentPage()==$paginator->lastPage()?$paginator->total():$paginator->currentPage()* $paginator->count())}}</span>
            trong tổng số
            <span class="font-medium">{{$paginator->total()}}</span>
            sản phẩm
        </p>
    </div>
</div>