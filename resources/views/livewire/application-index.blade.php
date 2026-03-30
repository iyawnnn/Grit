<div class="flex flex-col gap-8 relative pb-12">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Your Job Pipeline</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Let's land that dream role. Track your progress and celebrate your wins.</p>
        </div>
        <a href="{{ route('applications.create') }}" 
           class="px-5 py-2.5 bg-[#e26a35] text-white rounded-xl text-sm font-semibold tracking-tight hover:bg-[#cf5b29] hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09l2.846.813-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
            </svg>
            Track New Role
        </a>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative w-full sm:flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by role or company..."
                class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm font-medium transition-all shadow-sm outline-none">
        </div>

        <div x-data="{ open: false, currentStatus: @entangle('status').live }" class="relative w-full sm:w-56 shrink-0 z-20">
            <button @click="open = !open" @click.away="open = false" type="button" 
                class="w-full flex justify-between items-center px-4 py-3 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none cursor-pointer">
                <span class="text-sm font-semibold text-gray-700" x-text="currentStatus ? currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1) : 'All Statuses'"></span>
                <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <div x-show="open" x-cloak x-transition.opacity style="display: none;" 
                 class="absolute right-0 mt-2 w-full rounded-xl bg-white shadow-lg border border-gray-100 overflow-hidden py-1">
                <button wire:click="$set('status', '')" @click="open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">All Statuses</button>
                <button wire:click="$set('status', 'saved')" @click="open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Saved</button>
                <button wire:click="$set('status', 'applied')" @click="open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Applied</button>
                <button wire:click="$set('status', 'interviewing')" @click="open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-[#e26a35] bg-[#fff5f0] hover:bg-[#ffece0] transition-colors">Interviewing</button>
                <button wire:click="$set('status', 'offered')" @click="open = false" class="w-full text-left px-4 py-2.5 text-sm font-bold text-gray-900 hover:bg-gray-50 transition-colors">Offered</button>
                <button wire:click="$set('status', 'rejected')" @click="open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Rejected</button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/30 hover:shadow-md transition-all flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-[#fff5f0] flex items-center justify-center text-[#e26a35] shrink-0 border border-[#e26a35]/10">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Tracked</p>
                <p class="text-3xl font-bold text-gray-900 tracking-tight leading-none mt-1">{{ $totalJobs }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/30 hover:shadow-md transition-all flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-[#fff5f0] flex items-center justify-center text-[#e26a35] shrink-0 border border-[#e26a35]/10">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Interviewing</p>
                <p class="text-3xl font-bold text-gray-900 tracking-tight leading-none mt-1">{{ $interviewingCount }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/30 hover:shadow-md transition-all flex items-center gap-5 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 w-full h-1 bg-[#e26a35]"></div>
            <div class="w-14 h-14 rounded-xl bg-[#fff5f0] flex items-center justify-center text-[#e26a35] shrink-0 border border-[#e26a35]/10">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Offers Received</p>
                <p class="text-3xl font-bold text-[#e26a35] tracking-tight leading-none mt-1">{{ $offeredCount }}</p>
            </div>
        </div>
    </div>

    <div class="relative min-h-[400px] z-10">
        
        <div wire:loading.flex wire:target="search, status, gotoPage" class="absolute inset-0 bg-[#f9fafb]/80 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl">
            <div class="flex flex-col items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-[#e26a35]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm font-semibold text-gray-600 tracking-tight">Syncing your pipeline...</span>
            </div>
        </div>

        @if($jobs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($jobs as $job)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-[#e26a35]/40 transition-all duration-300 flex flex-col p-6 group h-full">
                        
                        <div class="flex justify-between items-center mb-5 shrink-0">
                            
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" @click.away="open = false" type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] uppercase tracking-wider font-bold transition-colors cursor-pointer
                                    {{ $job->status === 'offered' ? 'bg-[#e26a35] text-white shadow-sm' : ($job->status === 'interviewing' ? 'bg-[#fff5f0] text-[#e26a35] border border-[#e26a35]/20' : 'bg-gray-100 text-gray-600 border border-gray-200 hover:bg-gray-200') }}">
                                    {{ $job->status ?? 'Saved' }}
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <div x-show="open" x-cloak x-transition.opacity style="display: none;" 
                                     class="absolute left-0 mt-2 w-40 rounded-xl bg-white shadow-xl border border-gray-100 z-20 overflow-hidden">
                                    <div class="p-1 flex flex-col gap-0.5">
                                        <button wire:click="updateStatus({{ $job->id }}, 'saved')" @click="open = false" class="text-left px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50 rounded-lg w-full">Saved</button>
                                        <button wire:click="updateStatus({{ $job->id }}, 'applied')" @click="open = false" class="text-left px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50 rounded-lg w-full">Applied</button>
                                        <button wire:click="updateStatus({{ $job->id }}, 'interviewing')" @click="open = false" class="text-left px-3 py-2 text-xs font-semibold text-[#e26a35] hover:bg-[#fff5f0] rounded-lg w-full">Interviewing</button>
                                        <button wire:click="updateStatus({{ $job->id }}, 'offered')" @click="open = false" class="text-left px-3 py-2 text-xs font-bold text-gray-900 hover:bg-gray-50 rounded-lg w-full">Offered</button>
                                        <button wire:click="updateStatus({{ $job->id }}, 'rejected')" @click="open = false" class="text-left px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50 rounded-lg w-full">Rejected</button>
                                    </div>
                                </div>
                            </div>

                            <span class="text-xs font-bold text-gray-400 tracking-tight">
                                {{ $job->created_at->format('M d') }}
                            </span>
                        </div>

                        <div class="mb-6 flex-1">
                            <h3 class="text-xl font-bold text-[#e26a35] tracking-tight leading-snug mb-2 group-hover:text-[#cf5b29] transition-colors">
                                {{ $job->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>{{ $job->company }}</span>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-gray-100 flex items-center justify-between mt-auto shrink-0">
                            <a href="{{ route('applications.show', $job) }}" 
                               class="text-sm font-bold text-gray-900 hover:text-[#e26a35] transition-colors tracking-tight flex items-center gap-1">
                                View Details
                                <svg class="w-4 h-4 opacity-0 -ml-2 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                            
                            <div class="flex items-center gap-4">
                                <a href="{{ route('applications.edit', $job) }}" 
                                   class="text-gray-400 hover:text-[#e26a35] transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                                <button type="button" wire:click="confirmDelete({{ $job->id }})" class="text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($jobs->hasPages())
                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            @endif
        @else
            <div class="w-full bg-[#fff5f0] rounded-3xl border border-[#e26a35]/10 overflow-hidden flex flex-col items-center justify-center text-center p-10 sm:p-16 shadow-sm">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-[#e26a35]/20">
                    <svg class="w-8 h-8 text-[#e26a35]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold tracking-tight text-gray-900 mb-2">No roles found</h3>
                <p class="text-sm font-medium tracking-tight text-gray-500 max-w-md mx-auto mb-8">
                    We could not find any job postings matching your current search or status filter.
                </p>
                <button type="button" wire:click="resetFilters" 
                   class="px-6 py-2.5 bg-white text-gray-900 border border-gray-200 rounded-xl text-sm font-bold tracking-tight hover:bg-gray-50 transition-colors shadow-sm">
                    Clear Filters
                </button>
            </div>
        @endif
    </div>

    @if($jobToDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-sm transition-opacity">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full shadow-2xl border border-gray-100">
                <div class="flex items-center justify-center w-14 h-14 mx-auto bg-[#fff5f0] rounded-full mb-5">
                    <svg class="w-7 h-7 text-[#e26a35]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-center text-gray-900 tracking-tight mb-2">Delete Application</h3>
                <p class="text-sm text-center font-medium text-gray-500 mb-8">Are you sure you want to remove this role? This action cannot be undone.</p>
                <div class="flex gap-3">
                    <button type="button" wire:click="cancelDelete" 
                        class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold tracking-tight hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="button" wire:click="executeDelete" 
                        class="flex-1 px-4 py-2.5 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] transition-colors shadow-sm">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>