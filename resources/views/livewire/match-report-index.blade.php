<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 relative"
    x-data="{ showCreateModal: @entangle('showCreateModal'), showDeleteModal: false }"
    @keydown.window.escape="showCreateModal = false; showDeleteModal = false">

    <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 mb-10">
        <div class="flex flex-col items-center md:items-start w-full md:w-auto">
            <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20">
                    <x-heroicon-o-chart-pie class="w-6 h-6 text-[#e26a35]" />
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Match Analysis</h1>
            </div>
            <p class="text-base font-medium text-gray-500 max-w-sm mx-auto md:mx-0">Analyze how well your resumes fit target roles.</p>
        </div>
        <button type="button" @click="showCreateModal = true"
            class="w-full md:w-auto justify-center px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
            <x-heroicon-o-plus class="w-5 h-5" />
            New Analysis
        </button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8 z-10 relative">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-document-magnifying-glass class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Reports</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalReports }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-check-badge class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Highest Score</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $highestScore }}%</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-arrow-path class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Processing</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $processingCount }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-8 z-30 relative">
        <div class="relative w-full md:flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by role, company, or resume..."
                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white text-sm font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
        </div>

        <div x-data="{ 
                open: false, 
                currentSort: @entangle('sort').live,
                get sortLabel() {
                    if (this.currentSort === 'newest') return 'Newest First';
                    if (this.currentSort === 'oldest') return 'Oldest First';
                    if (this.currentSort === 'score_high') return 'Highest Score';
                    if (this.currentSort === 'score_low') return 'Lowest Score';
                    return 'Sort by';
                }
            }" class="relative w-full md:w-64 shrink-0">

            <button type="button" @click="open = !open" @click.outside="open = false"
                class="w-full flex justify-between items-center px-4 py-3.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none cursor-pointer">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-arrows-up-down class="w-4 h-4 text-gray-400" />
                    <span class="font-bold text-gray-700" x-text="sortLabel"></span>
                </div>
                <x-heroicon-o-chevron-down class="h-4 w-4 text-gray-400 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <div x-show="open" x-cloak x-transition.opacity style="display: none;"
                class="absolute right-0 mt-2 w-full rounded-xl bg-white shadow-xl border border-gray-100 overflow-hidden py-2 z-50">
                <button type="button" wire:click.prevent="$set('sort', 'newest')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-bold transition-colors"
                    :class="currentSort === 'newest' ? 'bg-[#fff5f0] text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50'">Newest First</button>
                <button type="button" wire:click.prevent="$set('sort', 'score_high')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-bold transition-colors"
                    :class="currentSort === 'score_high' ? 'bg-[#fff5f0] text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50'">Highest Score</button>
            </div>
        </div>
    </div>

    <div class="relative min-h-[400px] z-10">

        <div wire:loading.grid wire:target="search, sort, gotoPage" class="absolute inset-0 z-10 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 bg-[#f9fafb]">
            @for ($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col h-full animate-pulse">
                <div class="flex justify-between items-start mb-6">
                    <div class="h-12 w-12 bg-gray-200 rounded-xl"></div>
                    <div class="h-6 w-16 bg-gray-100 rounded-md"></div>
                </div>
                <div class="h-6 w-3/4 bg-gray-200 rounded-md mb-2"></div>
                <div class="h-4 w-1/2 bg-gray-100 rounded-md mb-8"></div>
                <div class="h-4 w-full bg-gray-100 rounded-md mt-auto"></div>
        </div>
        @endfor
    </div>

    <div wire:loading.remove wire:target="search, sort, gotoPage">
        @if($matches->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($matches as $match)
            <div wire:key="match-card-{{ $match->id }}"
                class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#e26a35]/40 hover:-translate-y-1 transition-all duration-300 flex flex-col p-6 group h-full">

                <div class="flex justify-between items-start mb-5">
                    @if($match->status === 'processing')
                    <div class="flex items-center justify-center w-14 h-14 bg-gray-50 border border-gray-200 rounded-2xl">
                        <svg class="animate-spin h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    @else
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl border transition-colors
                                        {{ $match->score >= 80 ? 'bg-green-50 border-green-200 text-green-700' : ($match->score >= 50 ? 'bg-[#fff5f0] border-[#e26a35]/30 text-[#e26a35]' : 'bg-red-50 border-red-200 text-red-700') }}">
                        <span class="text-xl font-black tracking-tighter">{{ $match->score }}</span>
                        <span class="text-xs font-bold -mt-2">%</span>
                    </div>
                    @endif

                    <div class="flex items-center gap-1.5 text-xs font-bold text-gray-400 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                        <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                        {{ $match->created_at->format('M d, Y') }}
                    </div>
                </div>

                <div class="mb-6 flex-1">
                    <h3 class="text-xl font-extrabold text-gray-900 leading-tight mb-1.5 group-hover:text-[#e26a35] transition-colors line-clamp-2">
                        {{ $match->jobPosting->title ?? 'Unknown Role' }}
                    </h3>
                    <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 mb-4">
                        <x-heroicon-o-building-office-2 class="w-4 h-4 opacity-70" />
                        {{ $match->jobPosting->company ?? 'Unknown Company' }}
                    </div>

                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex items-center gap-3">
                        <div class="p-1.5 bg-white rounded-md shadow-sm border border-gray-200 shrink-0">
                            <x-heroicon-s-document-text class="w-4 h-4 text-[#e26a35]" />
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Resume Used</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $match->resume->label ?? 'Deleted Resume' }}</p>
                        </div>
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-100 flex items-center justify-between mt-auto shrink-0">
                    <a href="{{ route('matches.show', $match) }}" class="text-sm font-bold text-gray-600 hover:text-[#e26a35] transition-colors flex items-center gap-1.5 group/link">
                        Full Report
                        <x-heroicon-o-arrow-right class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all duration-300" />
                    </a>

                    <button type="button" @click="$wire.confirmDelete({{ $match->id }}); showDeleteModal = true"
                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                        <x-heroicon-o-trash class="w-5 h-5" />
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        @if($matches->hasPages())
        <div class="mt-10 custom-pagination">
            {{ $matches->links() }}
        </div>
        @endif
        @else
        <div class="w-full bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center text-center p-16 sm:p-24 shadow-sm">
            <div class="w-20 h-20 bg-[#fff5f0] rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-[#e26a35]/10">
                <x-heroicon-o-document-magnifying-glass class="w-10 h-10 text-[#e26a35]" />
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">No match reports found</h3>
            <p class="text-base font-medium text-gray-500 max-w-md mx-auto mb-8">
                Generate a report to see how well your resume scores against a specific job posting.
            </p>
            <button type="button" @click="showCreateModal = true"
                class="px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
                <x-heroicon-o-plus class="w-5 h-5" />
                Run First Analysis
            </button>
        </div>
        @endif
    </div>
</div>

<div x-show="showCreateModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
    <div x-show="showCreateModal" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="showCreateModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.away="showCreateModal = false"
                class="relative transform overflow-visible rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full sm:max-w-2xl border border-gray-100 flex flex-col">

                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50 rounded-t-2xl shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="p-1.5 bg-white rounded-lg shadow-sm border border-gray-200">
                            <x-heroicon-o-cpu-chip class="w-5 h-5 text-[#e26a35]" />
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 tracking-tight" id="modal-title">New Match Analysis</h3>
                    </div>
                    <button type="button" @click="showCreateModal = false" class="text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg p-1.5 transition-colors">
                        <span class="sr-only">Close panel</span>
                        <x-heroicon-o-x-mark class="h-6 w-6" />
                    </button>
                </div>

                <div class="flex-1 overflow-hidden">
                    @livewire('create-match-report')
                </div>
            </div>
        </div>
    </div>
</div>

<x-delete-modal
    show="showDeleteModal"
    title="Delete Match Report"
    description="Are you sure you want to remove this match report? This action cannot be undone."
    on-confirm="executeDelete"
    on-cancel="cancelDelete" />
</div>