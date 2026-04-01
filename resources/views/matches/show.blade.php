<x-app-layout>
    <x-slot:title>Match Report: {{ $matchReport->jobPosting->title ?? 'Role' }}</x-slot:title>

    @if($matchReport->status === 'processing')
        <script>
            setTimeout(function() {
                window.location.reload();
            }, 4000);
        </script>
    @endif

    <div class="max-w-7xl mx-auto py-8 xl:py-12 px-4 sm:px-6 lg:px-8 relative" x-data="{ showDeleteModal: false }">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8 border-b border-gray-200 pb-6">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('matches.index') }}"
                    class="p-2.5 bg-white border border-gray-200 text-gray-500 rounded-xl hover:text-[#e26a35] hover:border-[#e26a35]/40 hover:bg-[#fff5f0] hover:shadow-sm transition-all shrink-0">
                    <x-heroicon-o-arrow-left class="w-5 h-5" />
                </a>
                <div class="min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 truncate">
                        {{ $matchReport->jobPosting->title ?? 'Untitled Role' }}
                    </h1>
                    <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 mt-1">
                        <x-heroicon-o-building-office-2 class="w-4 h-4 opacity-70" />
                        <span class="truncate">{{ $matchReport->jobPosting->company ?? 'Unknown Company' }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($matchReport->status === 'processing')
            <div class="w-full bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center text-center p-16 sm:p-24 shadow-sm min-h-[500px]">
                <div class="relative w-24 h-24 mb-8">
                    <div class="absolute inset-0 border-4 border-[#fff5f0] rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-[#e26a35] rounded-full border-t-transparent animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <x-heroicon-o-cpu-chip class="w-8 h-8 text-[#e26a35] animate-pulse" />
                    </div>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">Analyzing Document</h3>
                <p class="text-base font-medium text-gray-500 max-w-md mx-auto">
                    Our AI is comparing your resume against the job requirements. This page will automatically refresh in a few seconds.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start relative z-10">

                <div class="xl:col-span-2 space-y-8">

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-[#fff5f0] rounded-xl border border-[#e26a35]/20 text-[#e26a35]">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 10.5h.008v.008H8.25V10.5zm7.5 0h.008v.008h-.008V10.5zm-5.25 4.5h3m-6-8.25h9A2.25 2.25 0 0118.75 9v6a2.25 2.25 0 01-2.25 2.25h-9A2.25 2.25 0 015.25 15V9A2.25 2.25 0 017.5 6.75z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75V3m-1.5 0h3M19.5 12h2.25m-19.5 0h2.25" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Match Analysis</h2>
                                    <p class="text-sm font-medium text-gray-500">AI-generated feedback on your fit for the role.</p>
                                </div>
                            </div>
                            
                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed prose-headings:font-bold prose-headings:text-gray-900 prose-a:text-[#e26a35] prose-strong:text-gray-900 prose-li:marker:text-[#e26a35]">
                                @if($matchReport->reasoning)
                                    {!! Str::markdown($matchReport->reasoning) !!}
                                @else
                                    <div class="p-6 bg-gray-50 rounded-xl border border-gray-100 text-center">
                                        <p class="text-gray-500 font-semibold">No detailed reasoning was generated for this report.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <livewire:action-plan-widget :matchReport="$matchReport" />

                    <div class="hidden xl:block bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 sm:p-8 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gray-50 rounded-xl border border-gray-200 text-gray-500">
                                    <x-heroicon-o-document-text class="w-6 h-6" />
                                </div>
                                <div>
                                    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Original Job Description</h2>
                                    <p class="text-sm font-medium text-gray-500">The text used for this analysis.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 sm:p-8 bg-gray-50/50">
                            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm max-h-[500px] overflow-y-auto custom-scrollbar">
                                <div class="prose prose-sm prose-gray max-w-none">
                                    {!! $matchReport->jobPosting->description ?? '<p class="text-gray-400 font-medium italic">No description provided.</p>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 xl:sticky xl:top-8">

                    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm flex flex-col items-center text-center">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-8">Overall Match</h2>

                        @php
                            $score = $matchReport->score ?? 0;
                            $radius = 60; 
                            $circumference = 2 * pi() * $radius;
                            $dashOffset = $circumference - ($score / 100) * $circumference;
                            $strokeColor = $score >= 80 ? 'text-green-500' : ($score >= 50 ? 'text-[#e26a35]' : 'text-red-500');
                        @endphp

                        <div class="relative w-48 h-48 mb-6 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90 absolute inset-0" viewBox="0 0 140 140">
                                <circle cx="70" cy="70" r="{{ $radius }}" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-100" />
                                <circle cx="70" cy="70" r="{{ $radius }}" stroke="currentColor" stroke-width="12" fill="transparent"
                                        stroke-linecap="round" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $dashOffset }}"
                                        class="{{ $strokeColor }} transition-all duration-1000 ease-out" />
                            </svg>
                            <div class="flex flex-col items-center justify-center relative z-10">
                                <span class="text-6xl font-black text-gray-900 tracking-tighter">{{ $score }}<span class="text-2xl text-gray-300 font-bold ml-1">%</span></span>
                            </div>
                        </div>

                        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100 mt-2">
                            <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                            Analyzed on {{ $matchReport->created_at->format('M d, Y') }}
                        </div>
                    </div>

                    @if(!empty($matchReport->missing_keywords))
                        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.15em] mb-4">Missing Keywords</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($matchReport->missing_keywords as $keyword)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-bold bg-[#fff5f0] text-[#e26a35] border border-[#e26a35]/20 shadow-sm">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

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

                    <div class="xl:hidden bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gray-50 rounded-xl border border-gray-200 text-gray-500">
                                    <x-heroicon-o-document-text class="w-6 h-6" />
                                </div>
                                <div>
                                    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Original Job Description</h2>
                                    <p class="text-sm font-medium text-gray-500">The text used for this analysis.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gray-50/50">
                            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm max-h-[500px] overflow-y-auto custom-scrollbar">
                                <div class="prose prose-sm prose-gray max-w-none">
                                    {!! $matchReport->jobPosting->description ?? '<p class="text-gray-400 font-medium italic">No description provided.</p>' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="button" @click="showDeleteModal = true"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-red-600 bg-white hover:bg-red-50 rounded-xl transition-all border border-red-100 shadow-sm">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            Delete Report
                        </button>
                    </div>

                </div>
            </div>
        @endif

        <div x-show="showDeleteModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
            <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showDeleteModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         @click.away="showDeleteModal = false"
                         class="relative transform overflow-hidden rounded-2xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md sm:p-6 border border-gray-100">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                                <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-extrabold leading-6 text-gray-900" id="modal-title">Delete Report</h3>
                                <div class="mt-2">
                                    <p class="text-sm font-medium text-gray-500">Are you sure you want to remove this match report? This action is permanent.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-3">
                            <form action="{{ route('matches.destroy', $matchReport) }}" method="POST" class="m-0 p-0 w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 transition-colors">
                                    Yes, delete it
                                </button>
                            </form>
                            <button type="button" @click="showDeleteModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: #d1d5db; }
    </style>
</x-app-layout>