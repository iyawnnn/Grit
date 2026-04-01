<div class="p-6 md:p-8" x-data="{ jobSelected: $wire.entangle('job_posting_id'), resumeSelected: $wire.entangle('resume_id') }">
    <form wire:submit="generate" class="flex flex-col gap-8 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
            <div class="flex flex-col h-[400px] border border-gray-200 rounded-2xl p-5 bg-gray-50/50 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-3 mb-5 shrink-0 relative z-10">
                    <div class="w-7 h-7 rounded-full bg-[#fff5f0] text-[#e26a35] flex items-center justify-center text-sm font-bold border border-[#e26a35]/20">1</div>
                    <label class="block text-base font-extrabold text-gray-900">Select Target Role</label>
                </div>

                <div class="sticky top-0 z-10 bg-gray-50/50 pb-4 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                        </div>
                        <input wire:model.live.debounce.300ms="searchJob" type="text" placeholder="Search roles..."
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar relative z-10">
                    @forelse($jobs as $job)
                        <div>
                            <input type="radio" id="job_{{ $job->id }}" wire:model="job_posting_id" value="{{ $job->id }}" class="peer sr-only" required />
                            <label for="job_{{ $job->id }}" 
                                class="flex items-center justify-between cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-[#e26a35]/40 peer-checked:border-[#e26a35] peer-checked:ring-2 peer-checked:ring-[#e26a35] peer-checked:bg-[#fff5f0] transition-all group">
                                <div class="flex flex-col min-w-0 pr-3">
                                    <span class="text-sm font-bold text-gray-900 group-[.peer:checked+&]:text-[#e26a35] truncate transition-colors">{{ $job->title }}</span>
                                    <span class="text-xs font-medium text-gray-500 truncate mt-1">{{ $job->company }}</span>
                                </div>
                                <div class="shrink-0 text-gray-200 group-[.peer:checked+&]:text-[#e26a35] transition-colors">
                                    <x-heroicon-s-check-circle class="w-6 h-6 opacity-0 group-[.peer:checked+&]:opacity-100 transition-opacity" />
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="p-6 text-center rounded-xl bg-white border border-gray-100 flex flex-col items-center justify-center h-full shadow-sm">
                            <x-heroicon-o-briefcase class="w-10 h-10 text-gray-200 mb-3" />
                            <p class="text-sm font-bold text-gray-500">No roles found.</p>
                        </div>
                    @endforelse
                </div>
                @error('job_posting_id') <span class="text-red-600 text-xs mt-3 font-bold block relative z-10">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col h-[400px] border border-gray-200 rounded-2xl p-5 bg-gray-50/50 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-3 mb-5 shrink-0 relative z-10">
                    <div class="w-7 h-7 rounded-full bg-[#fff5f0] text-[#e26a35] flex items-center justify-center text-sm font-bold border border-[#e26a35]/20">2</div>
                    <label class="block text-base font-extrabold text-gray-900">Choose Resume</label>
                </div>

                <div class="sticky top-0 z-10 bg-gray-50/50 pb-4 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                        </div>
                        <input wire:model.live.debounce.300ms="searchResume" type="text" placeholder="Search resumes..."
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar relative z-10">
                    @forelse($resumes as $resume)
                        <div>
                            <input type="radio" id="resume_{{ $resume->id }}" wire:model="resume_id" value="{{ $resume->id }}" class="peer sr-only" required />
                            <label for="resume_{{ $resume->id }}" 
                                class="flex items-center justify-between cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-[#e26a35]/40 peer-checked:border-[#e26a35] peer-checked:ring-2 peer-checked:ring-[#e26a35] peer-checked:bg-[#fff5f0] transition-all group">
                                <div class="flex flex-col min-w-0 pr-3 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-900 group-[.peer:checked+&]:text-[#e26a35] truncate transition-colors">{{ $resume->label }}</span>
                                        @if($resume->is_primary)
                                            <span class="px-2 py-0.5 rounded-md bg-[#e26a35]/10 text-[#e26a35] text-[10px] font-black uppercase tracking-wider shrink-0">Primary</span>
                                        @endif
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 mt-1 flex items-center gap-1.5">
                                        <x-heroicon-o-document-text class="w-4 h-4 opacity-70" />
                                        Parsed Document
                                    </span>
                                </div>
                                <div class="shrink-0 text-gray-200 group-[.peer:checked+&]:text-[#e26a35] transition-colors">
                                    <x-heroicon-s-check-circle class="w-6 h-6 opacity-0 group-[.peer:checked+&]:opacity-100 transition-opacity" />
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="p-6 text-center rounded-xl bg-white border border-gray-100 flex flex-col items-center justify-center h-full shadow-sm">
                            <x-heroicon-o-document-arrow-up class="w-10 h-10 text-gray-200 mb-3" />
                            <p class="text-sm font-bold text-gray-500">No resumes found.</p>
                        </div>
                    @endforelse
                </div>
                @error('resume_id') <span class="text-red-600 text-xs mt-3 font-bold block relative z-10">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end shrink-0 gap-4">
            <span x-show="!jobSelected || !resumeSelected" class="text-sm font-bold text-gray-400 transition-opacity">
                Please select both to continue.
            </span>
            <button type="submit" 
                x-bind:disabled="!jobSelected || !resumeSelected"
                wire:loading.attr="disabled"
                class="w-full sm:w-auto px-8 py-3.5 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] transition-all duration-200 shadow-md flex items-center justify-center gap-2 disabled:bg-gray-100 disabled:text-gray-400 disabled:hover:bg-gray-100 disabled:shadow-none disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="generate">Run Match Analysis</span>
                <span wire:loading.flex wire:target="generate" class="items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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