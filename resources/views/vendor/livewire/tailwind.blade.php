@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between w-full mt-4">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default rounded-xl shadow-sm">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <button type="button" wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:text-brand-orange hover:bg-brand-orange-light hover:border-brand-orange/30 focus:outline-none focus:ring-2 focus:ring-brand-orange/20 transition-all duration-200">
                    {!! __('pagination.previous') !!}
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:text-brand-orange hover:bg-brand-orange-light hover:border-brand-orange/30 focus:outline-none focus:ring-2 focus:ring-brand-orange/20 transition-all duration-200">
                    {!! __('pagination.next') !!}
                </button>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default rounded-xl shadow-sm">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Showing
                    <span class="font-bold text-gray-900">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-bold text-gray-900">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-bold text-gray-900">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-xl shadow-sm overflow-hidden border border-gray-200">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 cursor-default border-r border-gray-200">
                                <x-heroicon-m-chevron-left class="w-5 h-5" />
                            </span>
                        </span>
                    @else
                        <button type="button" wire:click="previousPage" aria-label="{{ __('pagination.previous') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white hover:text-brand-orange hover:bg-brand-orange-light focus:z-20 focus:outline-none focus:ring-2 focus:ring-brand-orange/30 transition-all duration-200 border-r border-gray-200">
                            <x-heroicon-m-chevron-left class="w-5 h-5" />
                        </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white cursor-default border-r border-gray-200">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-brand-orange cursor-default border-r border-brand-orange z-10">{{ $page }}</span>
                                    </span>
                                @else
                                    <button type="button" wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-white hover:text-brand-orange hover:bg-brand-orange-light focus:z-20 focus:outline-none focus:ring-2 focus:ring-brand-orange/30 transition-all duration-200 border-r border-gray-200" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage" aria-label="{{ __('pagination.next') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white hover:text-brand-orange hover:bg-brand-orange-light focus:z-20 focus:outline-none focus:ring-2 focus:ring-brand-orange/30 transition-all duration-200">
                            <x-heroicon-m-chevron-right class="w-5 h-5" />
                        </button>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 cursor-default">
                                <x-heroicon-m-chevron-right class="w-5 h-5" />
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif