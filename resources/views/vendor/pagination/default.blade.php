<div class="flex justify-end">
    <nav class="flex items-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="bg-neutral-200 rounded-tl-md rounded-bl-md p-2 flex items-start justify-center">
                <span class="material-symbols-outlined text-zinc-400" style="font-size: 16px">
                    arrow_back_ios_new
                </span>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">
                <button class="bg-blue-500 rounded-tl-md rounded-bl-md p-2 flex items-start justify-center">
                    <span class="material-symbols-outlined text-white" style="font-size: 16px">
                        arrow_back_ios_new
                    </span>
                </button>
            </a>
        @endif

        {{-- Pagination Links --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="text-gray-500">{{ $element }}</span>
            @elseif (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-blue-500 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1 bg-gray-200 text-gray-700 hover:bg-gray-300">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                <button class="bg-blue-500 rounded-tr-md rounded-br-md p-2 flex items-start justify-center">
                    <span class="material-symbols-outlined text-white" style="font-size: 16px">
                        arrow_forward_ios
                    </span>
                </button>
            </a>
        @else
            <button class="bg-gray-200 rounded-tr-md rounded-br-md p-2 flex items-start justify-center">
                <span class="material-symbols-outlined text-zinc-400" style="font-size: 16px">
                    arrow_forward_ios
                </span>
            </button>
        @endif
    </nav>
</div>
