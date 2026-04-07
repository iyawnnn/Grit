<div class="max-w-7xl mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8" x-data="{ showDeleteModal: @entangle('showDeleteModal') }">

    <a href="{{ route('cover-letters.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#e26a35] transition-colors mb-6 group w-fit">
        <x-heroicon-o-arrow-left class="w-4 h-4 mr-1.5 group-hover:-translate-x-1 transition-transform" />
        Back to Cover Letters
    </a>

    <div class="mb-8 flex flex-col xl:flex-row xl:items-end justify-between gap-6">
        <div class="flex items-start sm:items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#fff5f0] border border-[#e26a35]/20 hidden sm:flex items-center justify-center shrink-0 mt-1 sm:mt-0">
                <x-heroicon-o-document-text class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight leading-tight">Cover Letter Editor</h1>
                <p class="text-sm font-medium text-gray-500 mt-1">
                    Target: <span class="text-gray-900 font-bold">{{ $jobPosting->title }}</span> at {{ $jobPosting->company }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full xl:w-auto">
            <a href="{{ route('applications.show', $jobPosting->id) }}" class="flex-1 xl:flex-none inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e26a35]/20">
                <x-heroicon-o-briefcase class="w-4 h-4 mr-1.5 text-gray-400" />
                View Job
            </a>
            
            <button wire:click="save" wire:loading.attr="disabled" class="flex-1 xl:flex-none flex justify-center items-center px-6 py-2.5 bg-[#e26a35] border border-transparent rounded-xl text-sm font-bold text-white hover:bg-[#cf5b29] hover:shadow-md transition-all focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50 disabled:opacity-70 disabled:cursor-wait">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-1.5">
                    <x-heroicon-o-check class="w-4 h-4" />
                    Save Letter
                </span>
                <span wire:loading.flex wire:target="save" class="items-center gap-1.5">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Saving...
                </span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
        
        <div class="xl:col-span-1 space-y-6 xl:sticky xl:top-8 order-2 xl:order-1">
            
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col">
                <h3 class="text-xs font-extrabold text-gray-500 uppercase tracking-widest mb-5">Application Context</h3>
                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Target Role</p>
                        <p class="text-sm font-bold text-gray-900">{{ $jobPosting->title }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Company</p>
                        <p class="text-sm font-bold text-[#e26a35]">{{ $jobPosting->company }}</p>
                    </div>
                </div>

                @if($jobPosting->cover_letter)
                    <div class="pt-5 border-t border-gray-100 mt-auto">
                        <button type="button" @click="showDeleteModal = true" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl text-sm font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-red-500/20">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            Discard Draft
                        </button>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-cpu-chip class="w-5 h-5 text-[#e26a35]" />
                            <h2 class="text-base font-extrabold text-gray-900">Grit Co-Pilot</h2>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed mb-6">
                        Instantly write a highly targeted cover letter using the job description and your best matching resume.
                    </p>

                    @if($errorMessage)
                        <div class="mb-5 p-3 rounded-xl bg-red-50 border border-red-100 text-red-700 text-xs font-semibold leading-relaxed shadow-sm">
                            <div class="flex gap-2">
                                <x-heroicon-o-exclamation-triangle class="w-4 h-4 shrink-0" />
                                <span>{{ $errorMessage }}</span>
                            </div>
                        </div>
                    @endif

                    <button wire:click="generate" wire:loading.attr="disabled" class="w-full flex justify-center py-3.5 px-4 bg-[#e26a35] hover:bg-[#cf5b29] text-white text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50 disabled:opacity-80 disabled:cursor-wait">
                        <span wire:loading.remove wire:target="generate" class="flex items-center gap-2">
                            <x-heroicon-s-pencil-square class="w-4 h-4 text-white/90" />
                            {{ $content ? 'Regenerate with AI' : 'Draft with AI' }}
                        </span>
                        <span wire:loading.flex wire:target="generate" class="items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span>Analyzing Data...</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 order-1 xl:order-2">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col h-[600px] xl:h-[calc(100vh-12rem)] relative overflow-hidden">
                
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $content ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-xs font-bold text-gray-600 uppercase tracking-widest">Document Text</span>
                    </div>
                    @if($content)
                        <button type="button" 
                            x-data="{ copied: false }"
                            @click="
                                navigator.clipboard.writeText(document.getElementById('content-editor').value);
                                copied = true;
                                $dispatch('notify', { message: 'Copied to clipboard!', type: 'success' });
                                setTimeout(() => copied = false, 2500);
                            " 
                            class="inline-flex items-center gap-1.5 text-xs font-bold transition-all px-3 py-1.5 rounded-lg border"
                            :class="copied ? 'bg-green-50 text-green-700 border-green-200' : 'bg-[#fff5f0] text-[#e26a35] hover:text-[#cf5b29] border-[#e26a35]/20'"
                        >
                            <x-heroicon-o-clipboard-document x-show="!copied" class="w-4 h-4" />
                            <x-heroicon-s-check-circle x-show="copied" x-cloak class="w-4 h-4" />
                            <span x-text="copied ? 'Copied!' : 'Copy Text'"></span>
                        </button>
                    @endif
                </div>

                <div class="flex-1 flex flex-col relative bg-white h-full">
                    
                    <div wire:loading wire:target="generate" class="absolute inset-0 z-20 bg-white p-8 sm:p-12 flex flex-col pointer-events-none">
                        <div class="flex items-center gap-3 mb-8">
                            <svg class="animate-spin h-5 w-5 text-[#e26a35]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="text-sm font-extrabold text-[#e26a35] uppercase tracking-widest animate-pulse">Drafting Document...</span>
                        </div>

                        <div class="space-y-4 w-full opacity-60">
                            <div class="h-3 bg-gray-200 rounded w-1/4 animate-pulse"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/3 animate-pulse mb-8"></div>
                            
                            <div class="h-2.5 bg-gray-100 rounded w-full animate-pulse delay-75"></div>
                            <div class="h-2.5 bg-gray-100 rounded w-full animate-pulse delay-100"></div>
                            <div class="h-2.5 bg-gray-100 rounded w-11/12 animate-pulse delay-150"></div>
                            <div class="h-2.5 bg-gray-100 rounded w-full animate-pulse delay-200"></div>
                            <div class="h-2.5 bg-gray-100 rounded w-4/5 animate-pulse delay-300"></div>
                        </div>
                    </div>

                    <textarea 
                        id="content-editor"
                        wire:model="content" 
                        class="flex-1 w-full h-full min-h-[600px] xl:min-h-full resize-none border-0 focus:ring-0 p-6 sm:p-10 text-gray-900 text-[15px] sm:text-base leading-[1.8] whitespace-pre-wrap font-sans bg-transparent outline-none custom-scrollbar placeholder-gray-400"
                        placeholder="Use the Grit Co-Pilot to write your first draft, or start typing your cover letter here..."
                        spellcheck="false"
                    ></textarea>
                </div>
            </div>
        </div>
    </div>

    <x-delete-modal show="showDeleteModal" title="Discard Draft"
        description="Are you sure you want to clear this cover letter draft? The job application itself will remain safe."
        on-confirm="executeDelete" on-cancel="showDeleteModal = false" />
</div>