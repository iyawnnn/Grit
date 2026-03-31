<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 relative" x-data="{ showDeleteModal: false }">

    <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 mb-10">
        <div class="flex flex-col items-center md:items-start w-full md:w-auto">
            <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20">
                    <x-heroicon-o-briefcase class="w-6 h-6 text-[#e26a35]" />
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Your Career Pipeline</h1>
            </div>
            <p class="text-base font-medium text-gray-500 max-w-sm mx-auto md:mx-0">Track your applications and manage
                your progress towards your next role.</p>
        </div>
        <a href="{{ route('applications.create') }}"
            class="w-full md:w-auto justify-center px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
            <x-heroicon-o-rocket-launch class="w-5 h-5" />
            Launch Application
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-document-duplicate class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Tracked</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalJobs }}</p>
            </div>
        </div>
        <div
            class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Interviewing</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $interviewingCount }}</p>
            </div>
        </div>
        <div
            class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-star class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Offers Received</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $offeredCount }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-8 z-30 relative">
        <div class="relative w-full md:flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search roles or companies..."
                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white text-sm font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
        </div>

        <div x-data="{ open: false, currentStatus: @entangle('status').live }" class="relative w-full md:w-64 shrink-0">
            <button type="button" @click="open = !open" @click.outside="open = false"
                class="w-full flex justify-between items-center px-4 py-3.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none cursor-pointer">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-funnel class="w-4 h-4 text-gray-400" />
                    <span class="font-bold text-gray-700"
                        x-text="currentStatus ? currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1) : 'Filter by Status'"></span>
                </div>
                <x-heroicon-o-chevron-down class="h-4 w-4 text-gray-400 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <div x-show="open" x-cloak x-transition.opacity style="display: none;"
                class="absolute right-0 mt-2 w-full rounded-xl bg-white shadow-xl border border-gray-100 overflow-hidden py-2 z-50">
                <button type="button" wire:click.prevent="$set('status', '')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-bold text-gray-900 hover:bg-gray-50 transition-colors">All
                    Statuses</button>
                <button type="button" wire:click.prevent="$set('status', 'matched')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">Matched</button>
                <button type="button" wire:click.prevent="$set('status', 'applied')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">Applied</button>
                <button type="button" wire:click.prevent="$set('status', 'interviewing')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">Interviewing</button>
                <button type="button" wire:click.prevent="$set('status', 'offered')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">Offered</button>
                <button type="button" wire:click.prevent="$set('status', 'hired')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">Hired</button>
                <button type="button" wire:click.prevent="$set('status', 'rejected')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">Rejected</button>
            </div>
        </div>
    </div>

    <div class="relative min-h-[400px] z-10">

        <div wire:loading.grid wire:target="search, status, gotoPage"
            class="absolute inset-0 z-10 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 bg-[#f9fafb]">
            @for ($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col h-full animate-pulse">
                    <div class="flex justify-between items-center mb-6">
                        <div class="h-7 w-24 bg-gray-200 rounded-full"></div>
                        <div class="h-4 w-16 bg-gray-100 rounded-md"></div>
                    </div>
                    <div class="mb-8 flex-1">
                        <div class="h-6 w-3/4 bg-gray-200 rounded-md mb-4"></div>
                        <div class="h-4 w-1/2 bg-gray-100 rounded-md"></div>
                    </div>
                    <div class="pt-5 border-t border-gray-50 flex items-center justify-between">
                        <div class="h-4 w-24 bg-gray-200 rounded-md"></div>
                        <div class="flex gap-3">
                            <div class="h-6 w-6 bg-gray-200 rounded-md"></div>
                            <div class="h-6 w-6 bg-gray-200 rounded-md"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div wire:loading.remove wire:target="search, status, gotoPage">
            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                        <div wire:key="job-card-{{ $job->id }}"
                            class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#e26a35]/40 hover:-translate-y-1 transition-all duration-300 flex flex-col p-6 group h-full">

                            <div class="flex justify-between items-start mb-6 shrink-0">
                                <div x-data="{ open: false }" wire:key="status-dropdown-{{ $job->id }}" class="relative">
                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer border bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100">
                                        {{ $job->status ?? 'matched' }}
                                        <x-heroicon-o-chevron-down class="w-3 h-3 opacity-70" />
                                    </button>

                                    <div x-show="open" x-cloak x-transition.opacity style="display: none;"
                                        class="absolute left-0 mt-2 w-40 rounded-xl bg-white shadow-xl border border-gray-100 z-50 overflow-hidden py-1">
                                        <button type="button" wire:click.prevent="updateStatus({{ $job->id }}, 'matched')"
                                            @click="open = false"
                                            class="text-left px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full">Matched</button>
                                        <button type="button" wire:click.prevent="updateStatus({{ $job->id }}, 'applied')"
                                            @click="open = false"
                                            class="text-left px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full">Applied</button>
                                        <button type="button" wire:click.prevent="updateStatus({{ $job->id }}, 'interviewing')"
                                            @click="open = false"
                                            class="text-left px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full">Interviewing</button>
                                        <button type="button" wire:click.prevent="updateStatus({{ $job->id }}, 'offered')"
                                            @click="open = false"
                                            class="text-left px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full">Offered</button>
                                        <button type="button" wire:click.prevent="updateStatus({{ $job->id }}, 'hired')"
                                            @click="open = false"
                                            class="text-left px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full">Hired</button>
                                        <button type="button" wire:click.prevent="updateStatus({{ $job->id }}, 'rejected')"
                                            @click="open = false"
                                            class="text-left px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full">Rejected</button>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-1.5 text-xs font-bold text-gray-400 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                                    <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                                    {{ $job->created_at->format('M d') }}
                                </div>
                            </div>

                            <div class="mb-6 flex-1">
                                <h3
                                    class="text-xl font-extrabold text-gray-900 leading-tight mb-2 group-hover:text-[#e26a35] transition-colors">
                                    {{ $job->title }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm font-semibold text-gray-500">
                                    <x-heroicon-o-building-office-2 class="w-4 h-4 opacity-70" />
                                    {{ $job->company }}
                                </div>
                            </div>

                            <div class="pt-5 border-t border-gray-100 flex items-center justify-between mt-auto shrink-0">
                                <a href="{{ route('applications.show', $job) }}"
                                    class="text-sm font-bold text-gray-600 hover:text-[#e26a35] transition-colors flex items-center gap-1.5 group/link">
                                    View Details
                                    <x-heroicon-o-arrow-up-right
                                        class="w-4 h-4 opacity-0 -translate-y-1 translate-x-1 group-hover/link:opacity-100 group-hover/link:translate-y-0 group-hover/link:translate-x-0 transition-all duration-300" />
                                </a>

                                <div class="flex items-center gap-3">
                                    <a href="{{ route('applications.edit', $job) }}"
                                        class="p-1.5 text-gray-400 hover:text-[#e26a35] hover:bg-[#fff5f0] rounded-lg transition-colors"
                                        title="Edit">
                                        <x-heroicon-o-pencil-square class="w-5 h-5" />
                                    </a>
                                    <button type="button" @click="$wire.confirmDelete({{ $job->id }}); showDeleteModal = true"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($jobs->hasPages())
                    <div class="mt-10 custom-pagination">
                        {{ $jobs->links() }}
                    </div>
                @endif
            @else
                @if(!$hasAnyJobs)
                    <div
                        class="w-full bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center text-center p-16 sm:p-24 shadow-sm">
                        <div
                            class="w-20 h-20 bg-[#fff5f0] rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-[#e26a35]/10">
                            <x-heroicon-o-rocket-launch class="w-10 h-10 text-[#e26a35]" />
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">Your pipeline is empty</h3>
                        <p class="text-base font-medium text-gray-500 max-w-md mx-auto mb-8">
                            You haven't tracked any job applications yet. Launch your first application to start staying
                            organized!
                        </p>
                        <a href="{{ route('applications.create') }}"
                            class="px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
                            <x-heroicon-o-plus class="w-5 h-5" />
                            Add First Application
                        </a>
                    </div>
                @else
                    <div
                        class="w-full bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center text-center p-16 sm:p-24 shadow-sm">
                        <div
                            class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-gray-200">
                            <x-heroicon-o-magnifying-glass class="w-10 h-10 text-gray-400" />
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">No matching roles</h3>
                        <p class="text-base font-medium text-gray-500 max-w-md mx-auto mb-8">
                            We couldn't find any applications matching your current search or filters.
                        </p>
                        <button type="button" wire:click.prevent="resetFilters"
                            class="px-6 py-3 bg-white text-gray-900 border border-gray-300 rounded-xl text-sm font-bold hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm flex items-center gap-2">
                            <x-heroicon-m-arrow-path class="w-5 h-5 text-gray-500" />
                            Clear Filters
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <x-delete-modal show="showDeleteModal" title="Delete Application"
        description="Are you sure you want to remove this role? This action cannot be undone."
        on-confirm="executeDelete" on-cancel="cancelDelete" />
</div>