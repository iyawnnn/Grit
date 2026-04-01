<div>
    <form wire:submit="generate" class="flex flex-col gap-6 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col h-[380px] border border-gray-200 rounded-2xl p-4 bg-gray-50/50">
                <div class="flex items-center gap-2 mb-4 shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#fff5f0] text-[#e26a35] flex items-center justify-center text-xs font-bold border border-[#e26a35]/20">1</div>
                    <label class="block text-sm font-extrabold text-gray-900">Select Target Role</label>
                </div>

                <div class="sticky top-0 z-10 bg-gray-50/50 pb-3 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                        </div>
                        <input wire:model.live.debounce.300ms="searchJob" type="text" placeholder="Search roles..."
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-200 bg-white text-xs font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto pr-2 space-y-2.5 custom-scrollbar">
                    @forelse($jobs as $job)
                        <div>
                            <input type="radio" id="job_{{ $job->id }}" wire:model="job_posting_id" value="{{ $job->id }}" class="peer sr-only" required />
                            <label for="job_{{ $job->id }}" 
                                class="flex items-center justify-between cursor-pointer rounded-xl border border-gray-200 bg-white p-3.5 shadow-sm hover:border-[#e26a35]/40 peer-checked:border-[#e26a35] peer-checked:ring-1 peer-checked:ring-[#e26a35] peer-checked:bg-[#fff5f0] transition-all group">
                                <div class="flex flex-col min-w-0 pr-3">
                                    <span class="text-sm font-bold text-gray-900 group-[.peer:checked+&]:text-[#e26a35] truncate transition-colors">{{ $job->title }}</span>
                                    <span class="text-xs font-medium text-gray-500 truncate mt-0.5">{{ $job->company }}</span>
                                </div>
                                <div class="shrink-0 text-gray-300 group-[.peer:checked+&]:text-[#e26a35] transition-colors">
                                    <x-heroicon-s-check-circle class="w-5 h-5 opacity-0 group-[.peer:checked+&]:opacity-100 transition-opacity" />
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="p-6 text-center rounded-xl bg-white border border-gray-100 flex flex-col items-center justify-center h-full">
                            <x-heroicon-o-briefcase class="w-8 h-8 text-gray-300 mb-2" />
                            <p class="text-sm font-bold text-gray-500">No roles found.</p>
                        </div>
                    @endforelse
                </div>
                @error('job_posting_id') <span class="text-red-600 text-xs mt-2 font-bold block">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col h-[380px] border border-gray-200 rounded-2xl p-4 bg-gray-50/50">
                <div class="flex items-center gap-2 mb-4 shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#fff5f0] text-[#e26a35] flex items-center justify-center text-xs font-bold border border-[#e26a35]/20">2</div>
                    <label class="block text-sm font-extrabold text-gray-900">Choose Resume</label>
                </div>

                <div class="sticky top-0 z-10 bg-gray-50/50 pb-3 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                        </div>
                        <input wire:model.live.debounce.300ms="searchResume" type="text" placeholder="Search resumes..."
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-200 bg-white text-xs font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto pr-2 space-y-2.5 custom-scrollbar">
                    @forelse($resumes as $resume)
                        <div>
                            <input type="radio" id="resume_{{ $resume->id }}" wire:model="resume_id" value="{{ $resume->id }}" class="peer sr-only" required />
                            <label for="resume_{{ $resume->id }}" 
                                class="flex items-center justify-between cursor-pointer rounded-xl border border-gray-200 bg-white p-3.5 shadow-sm hover:border-[#e26a35]/40 peer-checked:border-[#e26a35] peer-checked:ring-1 peer-checked:ring-[#e26a35] peer-checked:bg-[#fff5f0] transition-all group">
                                <div class="flex flex-col min-w-0 pr-3 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-900 group-[.peer:checked+&]:text-[#e26a35] truncate transition-colors">{{ $resume->label }}</span>
                                        @if($resume->is_primary)
                                            <span class="px-1.5 py-0.5 rounded-md bg-[#e26a35]/10 text-[#e26a35] text-[10px] font-black uppercase tracking-wider shrink-0">Primary</span>
                                        @endif
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 mt-0.5 flex items-center gap-1.5">
                                        <x-heroicon-o-document-text class="w-3.5 h-3.5 opacity-70" />
                                        Parsed Document
                                    </span>
                                </div>
                                <div class="shrink-0 text-gray-300 group-[.peer:checked+&]:text-[#e26a35] transition-colors">
                                    <x-heroicon-s-check-circle class="w-5 h-5 opacity-0 group-[.peer:checked+&]:opacity-100 transition-opacity" />
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="p-6 text-center rounded-xl bg-white border border-gray-100 flex flex-col items-center justify-center h-full">
                            <x-heroicon-o-document-arrow-up class="w-8 h-8 text-gray-300 mb-2" />
                            <p class="text-sm font-bold text-gray-500">No resumes found.</p>
                        </div>
                    @endforelse
                </div>
                @error('resume_id') <span class="text-red-600 text-xs mt-2 font-bold block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end shrink-0 mt-2">
            <button type="submit" wire:loading.attr="disabled"
                class="w-full md:w-auto px-8 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] transition-all duration-200 shadow-sm flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="generate">Run Match Analysis</span>
                <span wire:loading.flex wire:target="generate" class="items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
            </button>
        </div>
    </form>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: #d1d5db; }
    </style>
</div>