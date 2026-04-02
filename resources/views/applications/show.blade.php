<x-app-layout>
    <x-slot:title>
        {{ $application->title }} at {{ $application->company }}
    </x-slot:title>
    <div x-data="{ showAnalysisModal: false }" class="max-w-[1200px] mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('applications.board') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#e26a35] transition-colors group">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-[#e26a35] transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Job Board
            </a>
        </div>

        @php
            // All badges default to Brand Orange, except Rejected which is Red
            $statusValue = $application->status->value ?? $application->status;
            $badgeClasses = match($statusValue) {
                'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                default => 'bg-[#fff5f0] text-[#e26a35] border-[#e26a35]/20',
            };
        @endphp

        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 sm:p-8 mb-6 flex flex-col md:flex-row md:items-start justify-between gap-6 relative overflow-hidden">
            
            <div class="flex flex-col sm:flex-row gap-5 items-start">
                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center border border-gray-100 shrink-0 shadow-sm">
                    <span class="text-2xl font-extrabold text-gray-400 uppercase tracking-widest">
                        {{ substr($application->company, 0, 1) }}
                    </span>
                </div>
                
                <div class="min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mb-2 truncate whitespace-normal">{{ $application->title }}</h1>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-base font-bold text-gray-600">{{ $application->company }}</span>
                        <span class="hidden sm:inline text-gray-300">&bull;</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClasses }}">
                            {{ $application->status->getLabel() ?? ucfirst($application->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('applications.edit', $application) }}" class="px-4 py-2.5 bg-gray-50 text-gray-700 text-sm font-bold rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-gray-900 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                    Edit
                </a>
                
                <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this application?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2.5 bg-white text-red-600 text-sm font-bold rounded-xl border border-red-200 hover:bg-red-50 transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-start relative">
            
            <div class="w-full lg:flex-1 space-y-6 min-w-0">
                <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 sm:p-8 overflow-hidden">
                    <h2 class="text-lg font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#e26a35]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        Job Description
                    </h2>
                    
                    @php
                        // SMART HTML TRIMMER
                        $cleanDescription = $application->description ?? '';
                        
                        // Replace 3 or more consecutive <br> tags with just two (a single paragraph break)
                        $cleanDescription = preg_replace('/(<br\s*\/?>\s*){3,}/i', '<br><br>', $cleanDescription);
                        
                        // Remove completely empty divs or paragraphs
                        $cleanDescription = preg_replace('/<(p|div)[^>]*>(\s|&nbsp;|<br\s*\/?>)*<\/(p|div)>/i', '', $cleanDescription);
                        
                        // Clean up excess whitespace at the ends
                        $cleanDescription = trim($cleanDescription);
                    @endphp

                    <div class="text-gray-700 font-medium leading-relaxed break-words space-y-4 [&>ul]:list-disc [&>ul]:pl-5 [&>ul>li]:mb-1 [&>strong]:text-gray-900 [&>strong]:font-extrabold [&>h1]:text-lg [&>h1]:font-bold [&>h2]:text-base [&>h2]:font-bold">
                        @if($cleanDescription)
                            {!! $cleanDescription !!}
                        @else
                            <p class="text-gray-400 italic">No job description was provided for this application.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[340px] xl:w-[380px] shrink-0 sticky top-6 space-y-6">
                
                <div class="bg-gray-50 rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-4">Application Details</h2>
                    
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-bold text-gray-500 mb-1">Added On</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $application->created_at->format('F j, Y') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-xs font-bold text-gray-500 mb-1">Last Updated</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $application->updated_at->diffForHumans() }}</dd>
                        </div>

                        @if($application->source_url)
                        <div class="pt-2">
                            <a href="{{ $application->source_url }}" target="_blank" rel="noopener noreferrer" class="w-full px-4 py-2.5 bg-white text-gray-700 text-sm font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-[#e26a35] transition-all shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                Visit Original Post
                            </a>
                        </div>
                        @endif
                    </dl>
                </div>

                <div class="bg-gradient-to-br from-[#fff5f0] to-white rounded-3xl border border-[#e26a35]/20 p-6 shadow-sm relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 text-[#e26a35]/5">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>

                    <div class="relative z-10">
                        <h2 class="text-lg font-extrabold text-gray-900 mb-2">AI Match Analysis</h2>
                        <p class="text-sm font-medium text-gray-600 mb-5 leading-snug">Generate a detailed report to see how well your resume matches this specific role.</p>
                        
                        <button @click="showAnalysisModal = true" type="button" class="w-full px-4 py-3 bg-[#e26a35] text-white text-sm font-bold rounded-xl hover:bg-[#cf5b29] hover:-translate-y-0.5 transition-all shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.75v16.5M14.25 3.75v16.5M3.75 6h16.5M3.75 18h16.5" /></svg>
                            Analyze Resume Fit
                        </button>
                    </div>
                </div>
            </div>
        </div>

<div x-show="showAnalysisModal" 
             style="display: none;" 
             class="relative z-50" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
             
            <div x-show="showAnalysisModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                 @click="showAnalysisModal = false"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    
                    <div x-show="showAnalysisModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-200">
                        
                        <div class="bg-white px-6 pb-6 pt-6 sm:px-8 sm:pt-8 sm:pb-8">
                            
                            <div class="flex items-start justify-between border-b border-gray-100 pb-5 mb-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-[#fff5f0] border border-[#e26a35]/20">
                                        <svg class="h-6 w-6 text-[#e26a35]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09l2.846.813-.813.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-extrabold leading-6 text-gray-900" id="modal-title">Run AI Match Analysis</h3>
                                        <p class="text-sm font-medium text-gray-500 mt-1">
                                            Your job is auto-selected. Just pick a resume to compare!
                                        </p>
                                    </div>
                                </div>
                                <button @click="showAnalysisModal = false" class="text-gray-400 hover:text-gray-600 transition-colors rounded-lg p-1 hover:bg-gray-50">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <div>
                                @livewire('create-match-report', ['jobPostingId' => $application->id])
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>