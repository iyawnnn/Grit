<div class="max-w-7xl mx-auto py-8 xl:py-12 px-4 sm:px-6 lg:px-8 relative font-['Instrument_Sans'] tracking-tight">

    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8 border-b border-gray-200 pb-6">
        <div class="flex items-center gap-4 w-full md:w-auto">
            {{-- CHANGED: Now points back to the main Interviews Dashboard --}}
            <a href="{{ route('interviews.index') }}"
                class="p-2.5 bg-white border border-gray-200 text-gray-500 rounded-xl hover:text-[#e26a35] hover:border-[#e26a35]/40 hover:bg-[#fff5f0] hover:shadow-sm transition-all shrink-0">
                <x-heroicon-o-arrow-left class="w-5 h-5" />
            </a>
            <div class="min-w-0">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 truncate">
                    AI Interview Prep
                </h1>
                <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 mt-1">
                    <x-heroicon-s-briefcase class="w-4 h-4 opacity-70" />
                    <span class="truncate">Role: {{ $matchReport->jobPosting->title ?? 'Unknown' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start relative z-10">
        
        <div class="xl:col-span-2 space-y-8">
            @if(empty($questions))
                <div class="bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center shadow-sm min-h-[400px]">
                    
                    <div wire:loading.remove wire:target="generateQuestions" class="w-full flex flex-col items-center justify-center text-center p-12 sm:p-20">
                        <div class="w-24 h-24 bg-[#fff5f0] rounded-[2rem] flex items-center justify-center mb-8 shadow-inner border border-[#e26a35]/10 transform rotate-3">
                            <x-heroicon-o-sparkles class="w-12 h-12 text-[#e26a35] -rotate-3" />
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">Generate Practice Questions</h3>
                        <p class="text-base font-medium text-gray-500 max-w-md mx-auto mb-8">
                            Our AI will analyze the job posting and your resume to generate 5 highly specific practice questions for this role.
                        </p>
                        <button wire:click="generateQuestions"
                            class="bg-[#e26a35] hover:bg-[#cf5b29] hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 px-8 rounded-xl transition-all duration-200 flex items-center gap-2">
                            Start Generation
                        </button>
                        
                        @error('api')
                            <div class="mt-6 p-4 bg-red-50 text-red-600 rounded-xl font-bold text-sm border border-red-100">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div wire:loading.flex wire:target="generateQuestions" class="w-full flex-col items-center justify-center text-center p-12 sm:p-20" style="display: none;">
                        <div class="relative w-24 h-24 mb-8">
                            <div class="absolute inset-0 border-4 border-[#fff5f0] rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-[#e26a35] rounded-full border-t-transparent animate-spin"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <x-heroicon-o-cpu-chip class="w-8 h-8 text-[#e26a35] animate-pulse" />
                            </div>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">Generating Questions</h3>
                        <p class="text-base font-medium text-gray-500 max-w-md mx-auto">
                            Our AI is crafting customized interview questions based on your resume and this specific role.
                        </p>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-[#fff5f0] rounded-xl border border-[#e26a35]/20 text-[#e26a35]">
                                <x-heroicon-o-chat-bubble-left-right class="w-6 h-6" />
                            </div>
                            <div>
                                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Practice Questions</h2>
                                <p class="text-sm font-medium text-gray-500">Take your time to formulate your responses.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 sm:p-8 bg-gray-50/50 space-y-6">
                        @foreach($questions as $index => $question)
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 hover:shadow-md transition-all group relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-1 h-full bg-[#e26a35] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <h3 class="text-xs font-black text-[#e26a35] uppercase tracking-[0.15em] mb-3">Question {{ $index + 1 }}</h3>
                                <p class="text-gray-900 font-semibold text-lg leading-relaxed">{{ $question }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-6 xl:sticky xl:top-8">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-6">
                <div>
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Target Role</h2>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 shrink-0 shadow-sm">
                            <x-heroicon-s-briefcase class="w-5 h-5" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $matchReport->jobPosting->title }}</p>
                            <p class="text-xs font-medium text-gray-500 truncate mt-0.5">{{ $matchReport->jobPosting->company }}</p>
                        </div>
                    </div>

                    @if($matchReport->jobPosting->source_url)
                        <a href="{{ $matchReport->jobPosting->source_url }}" target="_blank"
                            class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 hover:text-[#e26a35] hover:border-[#e26a35]/30 transition-all shadow-sm">
                            <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4" />
                            View Original Posting
                        </a>
                    @endif
                </div>

                <hr class="border-gray-100">

                <div>
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Resume Evaluated</h2>
                    @if($matchReport->resume)
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-[#fff5f0] border border-[#e26a35]/20 flex items-center justify-center text-[#e26a35] shrink-0 shadow-sm">
                                <x-heroicon-s-document-text class="w-5 h-5" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $matchReport->resume->label }}</p>
                                <p class="text-xs font-medium text-gray-500 truncate mt-0.5">Parsed Data</p>
                            </div>
                        </div>

                        <a href="{{ route('resumes.show', $matchReport->resume) }}"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 hover:text-[#e26a35] hover:border-[#e26a35]/30 transition-all shadow-sm">
                            <x-heroicon-o-eye class="w-4 h-4" />
                            Open Resume
                        </a>
                    @else
                        <p class="text-sm font-bold text-gray-500 text-center py-2">No linked resume.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>