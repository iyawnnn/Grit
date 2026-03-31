<div class="max-w-[1600px] mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Job Board</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Track your applications from wishlist to offer.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative w-full md:w-64 hidden sm:block">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search company or role..." 
                    class="block w-full pl-10 rounded-xl border-gray-200 bg-white py-2 text-sm font-medium focus:border-[#e26a35] focus:ring-[#e26a35] shadow-sm transition-all">
            </div>
            
            <a href="{{ route('applications.create') }}" class="px-4 py-2.5 bg-[#e26a35] text-white text-sm font-bold rounded-xl hover:bg-[#d15823] transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <span class="hidden sm:inline">Add Job</span>
            </a>
        </div>
    </div>

    <div class="flex overflow-x-auto pb-4 gap-6 snap-x snap-mandatory custom-scrollbar items-start h-[calc(100vh-220px)] min-h-[600px]">
        
        @foreach($statuses as $status)
            @php
                $columnJobs = $jobs->filter(fn($j) => $j->status === $status || $j->status === $status->value);
            @endphp

            <div wire:key="col-{{ $status->value }}" class="flex-shrink-0 w-80 sm:w-80 w-[85vw] bg-gray-50/80 rounded-2xl border border-gray-200 flex flex-col snap-center h-full overflow-hidden relative">
                
                <div class="p-4 border-b border-gray-200/70 flex justify-between items-center bg-white shadow-sm z-20">
                    <h3 class="font-extrabold text-gray-900 uppercase tracking-wide text-xs">
                        {{ $status->getLabel() }}
                    </h3>
                    <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2.5 py-1 rounded-lg">
                        {{ $columnJobs->count() }}
                    </span>
                </div>

                <div wire:loading wire:target="updateStatus, search" class="absolute inset-0 top-[60px] bg-gray-50/60 backdrop-blur-sm z-10 p-3 flex flex-col gap-3">
                    <div class="h-28 bg-gray-200 animate-pulse rounded-xl"></div>
                    <div class="h-28 bg-gray-200 animate-pulse rounded-xl opacity-70"></div>
                    <div class="h-28 bg-gray-200 animate-pulse rounded-xl opacity-40"></div>
                </div>

                <div class="p-3 flex-1 overflow-y-auto space-y-3 custom-scrollbar transition-all duration-200"
                     x-data="{ isDroppable: false }"
                     @dragover.prevent="isDroppable = true"
                     @dragleave.prevent="isDroppable = false"
                     @drop="isDroppable = false; $wire.updateStatus(event.dataTransfer.getData('jobId'), '{{ $status->value }}')"
                     :class="isDroppable ? 'bg-[#fff5f0] border-2 border-dashed border-[#e26a35]/50 rounded-xl' : 'border-2 border-transparent'"
                >
                    @foreach($columnJobs as $job)
                        <div wire:key="job-{{ $job->id }}" draggable="true"
                             @dragstart="event.dataTransfer.setData('jobId', {{ $job->id }}); event.dataTransfer.effectAllowed = 'move'; $el.classList.add('opacity-50', 'scale-95');"
                             @dragend="$el.classList.remove('opacity-50', 'scale-95');"
                             class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm sm:cursor-grab active:cursor-grabbing hover:border-[#e26a35]/50 transition-all relative flex flex-col gap-2">
                            
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-900 text-sm leading-tight pr-6">{{ $job->title }}</h4>
                                <a href="{{ route('applications.show', $job) }}" class="text-gray-400 hover:text-[#e26a35] transition-colors shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </div>
                            
                            <p class="text-xs font-medium text-gray-500">{{ $job->company }}</p>
                            
                            <div class="sm:hidden mt-2 pt-2 border-t border-gray-100">
                                <select wire:change="updateStatus({{ $job->id }}, $event.target.value)" 
                                    class="block w-full rounded-lg border-gray-200 bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-700 focus:border-[#e26a35] focus:ring-[#e26a35] outline-none">
                                    @foreach($statuses as $opt)
                                        <option value="{{ $opt->value }}" @if($job->status === $opt || $job->status === $opt->value) selected @endif>
                                            Move to {{ $opt->getLabel() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: #d1d5db; }
    </style>
</div>