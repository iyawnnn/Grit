<div class="max-w-[1600px] mx-auto py-6 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-5 md:p-6 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        
        <div class="flex flex-col md:flex-row items-center gap-4 text-center md:text-left">
            <div class="w-14 h-14 rounded-2xl bg-[#fff5f0] flex items-center justify-center border border-[#e26a35]/20 shrink-0 shadow-sm">
                <svg class="w-7 h-7 text-[#e26a35]" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.75v16.5M14.25 3.75v16.5" />
                </svg>
            </div>
            
            <div>
                <div class="flex flex-col md:flex-row items-center md:justify-start gap-2">
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Job Board</h1>
                    
                    <div wire:loading wire:target="updateStatus, search" class="hidden md:flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-full transition-all duration-200" aria-live="polite">
                        <svg class="animate-spin h-3 w-3 text-[#e26a35]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span class="text-[10px] font-bold text-gray-600 uppercase tracking-wider">Syncing</span>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-600 mt-1">Track your applications from wishlist to offer.</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center w-full md:w-auto gap-3">
            
            <div class="relative w-full md:w-72">
                <label for="search-jobs" class="sr-only">Search company or role</label>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                </div>
                <input type="text" id="search-jobs" wire:model.live.debounce.300ms="search" placeholder="Search company or role..." 
                    class="block w-full pl-10 rounded-xl border-gray-200 bg-gray-50 py-2.5 text-sm font-medium focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all outline-none shadow-sm">
            </div>
            
            <a href="{{ route('applications.create') }}" aria-label="Add a new job application" class="w-full md:w-auto px-5 py-2.5 bg-[#e26a35] text-white text-sm font-bold rounded-xl hover:bg-[#cf5b29] hover:-translate-y-0.5 transition-all shadow-sm flex items-center justify-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <span>Add Job</span>
            </a>
        </div>
        
        <div wire:loading wire:target="updateStatus, search" class="absolute top-0 left-0 h-1 bg-[#e26a35] animate-pulse w-full md:hidden"></div>
    </div>

    <div class="flex xl:grid xl:grid-cols-5 overflow-x-auto xl:overflow-visible pb-4 gap-4 sm:gap-5 snap-x snap-mandatory custom-scrollbar items-stretch h-[calc(100vh-230px)] min-h-[600px]">
        
        @foreach($statuses as $status)
            @php
                $columnJobs = $jobs->filter(fn($j) => $j->status === $status || $j->status === $status->value);
                
                $dotColor = match($status->getColor()) {
                    'gray' => 'bg-gray-500',
                    'info' => 'bg-blue-600',
                    'warning' => 'bg-amber-500',
                    'success' => 'bg-emerald-600',
                    'danger' => 'bg-rose-600',
                    default => 'bg-[#e26a35]',
                };
            @endphp

            <div wire:key="col-{{ $status->value }}" class="flex-shrink-0 w-[85vw] sm:w-[320px] xl:w-auto bg-gray-50/80 rounded-2xl border border-gray-200/80 flex flex-col snap-center h-full overflow-hidden relative">
                
                <div class="px-4 py-3.5 border-b border-gray-200/70 bg-white/60 flex justify-between items-center z-20 backdrop-blur-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $dotColor }} shadow-sm" aria-hidden="true"></div>
                        <h2 class="font-extrabold text-gray-800 uppercase tracking-wide text-[11px]">
                            {{ $status->getLabel() }}
                        </h2>
                    </div>
                    <span class="bg-white border border-gray-200 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm" aria-label="{{ $columnJobs->count() }} jobs in this column">
                        {{ $columnJobs->count() }}
                    </span>
                </div>

                <div class="p-3 flex-1 overflow-y-auto custom-scrollbar transition-all duration-200 flex flex-col gap-3"
                     x-data="{ isDroppable: false }"
                     @dragover.prevent="isDroppable = true"
                     @dragleave.prevent="isDroppable = false"
                     @drop="isDroppable = false; $wire.updateStatus(event.dataTransfer.getData('jobId'), '{{ $status->value }}')"
                     :class="isDroppable ? 'bg-[#fff5f0] border-2 border-dashed border-[#e26a35]/50 rounded-xl m-1' : 'border-2 border-transparent'"
                >
                    
                    @forelse($columnJobs as $job)
                        <div wire:key="job-{{ $job->id }}" draggable="true"
                             @dragstart="event.dataTransfer.setData('jobId', {{ $job->id }}); event.dataTransfer.effectAllowed = 'move'; $el.classList.add('opacity-50', 'scale-[0.98]');"
                             @dragend="$el.classList.remove('opacity-50', 'scale-[0.98]');"
                             class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm sm:cursor-grab active:cursor-grabbing hover:border-[#e26a35]/40 hover:shadow-md transition-all duration-200 relative group flex flex-col gap-2">
                            
                            <div class="flex-1 min-w-0 pr-2">
                                <h3 class="font-extrabold text-gray-900 text-sm truncate leading-tight mb-0.5 group-hover:text-[#e26a35] transition-colors">{{ $job->title }}</h3>
                                <p class="text-xs font-medium text-gray-600 truncate">{{ $job->company }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-1 pt-3 border-t border-gray-50">
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span class="sr-only">Last updated</span> {{ $job->updated_at->diffForHumans() }}
                                </span>

                                <a href="{{ route('applications.show', $job) }}" aria-label="View details for {{ $job->title }} at {{ $job->company }}" class="text-gray-400 hover:text-[#e26a35] transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                </a>
                            </div>

                            <div class="sm:hidden mt-2 pt-2 border-t border-gray-50">
                                <label for="status-{{ $job->id }}" class="sr-only">Update status for {{ $job->title }}</label>
                                <select id="status-{{ $job->id }}" wire:change="updateStatus({{ $job->id }}, $event.target.value)" 
                                    class="block w-full rounded-lg border-gray-200 bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-700 focus:border-[#e26a35] focus:ring-[#e26a35] outline-none">
                                    @foreach($statuses as $opt)
                                        <option value="{{ $opt->value }}" @if($job->status === $opt || $job->status === $opt->value) selected @endif>
                                            Move to {{ $opt->getLabel() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @empty
                        <div class="flex-1 flex flex-col items-center justify-center border-2 border-dashed border-gray-200/80 rounded-xl bg-gray-50/50 text-center p-6 min-h-[120px] pointer-events-none opacity-80" aria-hidden="true">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 mb-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                            <p class="text-[11px] font-extrabold text-gray-500 uppercase tracking-wider">Drop Here</p>
                        </div>
                    @endforelse

                </div>
            </div>
        @endforeach
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; border: 2px solid transparent; background-clip: padding-box; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: #94a3b8; }
    </style>
</div>