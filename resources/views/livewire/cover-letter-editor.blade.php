<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 relative" x-data="{ showDeleteModal: false }">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div class="flex flex-col items-start w-full md:w-auto">
            <a href="{{ route('cover-letters.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#e26a35] transition-colors mb-3">
                <x-heroicon-o-arrow-left class="w-3.5 h-3.5 mr-1.5" />
                Back to Cover Letters
            </a>
            <div class="flex items-center gap-3">
                <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20 shrink-0">
                    <x-heroicon-o-envelope-open class="w-6 h-6 text-[#e26a35]" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Document Editor</h1>
                    <p class="text-sm font-medium text-gray-500 mt-0.5">Editing cover letter for <span class="text-gray-700 font-bold">{{ $jobPosting->title }}</span></p>
                </div>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <a href="{{ route('applications.show', $jobPosting->id) }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e26a35]/20">
                <x-heroicon-o-briefcase class="w-4 h-4 mr-1.5 text-gray-400" />
                View App
            </a>

            @if($jobPosting->cover_letter)
                <button type="button" @click="showDeleteModal = true" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-red-200 rounded-xl text-sm font-bold text-red-600 hover:bg-red-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500/20">
                    <x-heroicon-o-trash class="w-4 h-4 mr-1.5" />
                    Delete
                </button>
            @endif

            <button wire:click="save" class="inline-flex items-center justify-center px-6 py-2.5 bg-[#e26a35] border border-transparent rounded-xl text-sm font-bold text-white hover:bg-[#cf5b29] hover:shadow-md hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50">
                <x-heroicon-o-check class="w-4 h-4 mr-1.5" />
                Save Changes
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-widest">AI Generation</h2>
                    <div class="w-8 h-8 rounded-full bg-[#fff5f0] flex items-center justify-center">
                        <x-heroicon-o-sparkles class="w-4 h-4 text-[#e26a35]" />
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-4 mb-6 border border-gray-100">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Target Role</p>
                    <h3 class="font-extrabold text-gray-900 line-clamp-1 mb-0.5">{{ $jobPosting->title }}</h3>
                    <p class="text-sm font-medium text-[#e26a35] line-clamp-1">{{ $jobPosting->company }}</p>
                </div>

                <div class="pt-2">
                    @if($errorMessage)
                        <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm font-medium leading-relaxed shadow-sm">
                            <div class="flex items-start gap-2">
                                <x-heroicon-o-exclamation-circle class="w-5 h-5 shrink-0 mt-0.5" />
                                <div>
                                    <strong class="block mb-1 font-bold text-red-800">Generation Failed</strong>
                                    {{ $errorMessage }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <p class="text-sm text-gray-500 mb-5 leading-relaxed">Let Grit's AI write your first draft using the best available resume context.</p>

                    <button wire:click="generate" wire:loading.attr="disabled" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-900/50 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="generate" class="flex items-center gap-2">
                            <x-heroicon-o-bolt class="w-4 h-4 text-yellow-400" />
                            {{ $content ? 'Regenerate Draft' : 'Generate Cover Letter' }}
                        </span>
                        <span wire:loading wire:target="generate" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Writing Draft...
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-gray-100 rounded-3xl border border-gray-200 overflow-hidden shadow-inner relative flex flex-col min-h-[750px]">
                
                <div class="px-6 py-4 bg-white border-b border-gray-200 flex justify-between items-center shadow-sm z-20">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $content ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Document Workspace</span>
                    </div>
                    @if($content)
                        <button onclick="navigator.clipboard.writeText(document.getElementById('content-editor').value); alert('Copied to clipboard!')" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#e26a35] hover:text-[#cf5b29] transition-colors bg-[#fff5f0] px-3 py-1.5 rounded-lg border border-[#e26a35]/20">
                            <x-heroicon-o-clipboard-document class="w-4 h-4" />
                            Copy Text
                        </button>
                    @endif
                </div>
                
                <div class="flex-1 relative p-6 sm:p-10 overflow-y-auto custom-scrollbar">
                    
                    <div wire:loading wire:target="generate" class="absolute inset-0 z-30 bg-gray-100/60 backdrop-blur-sm flex items-center justify-center">
                        <div class="bg-white p-6 rounded-2xl shadow-xl flex flex-col items-center gap-4 border border-gray-100">
                            <svg class="animate-spin h-8 w-8 text-[#e26a35]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="text-sm font-extrabold text-gray-800">Drafting your letter...</span>
                        </div>
                    </div>

                    <div class="bg-white mx-auto max-w-3xl min-h-full rounded-xl shadow-sm border border-gray-200/60 p-8 sm:p-12 transition-all hover:shadow-md">
                        <textarea 
                            id="content-editor"
                            wire:model="content" 
                            class="w-full h-full min-h-[600px] resize-none border-0 focus:ring-0 p-0 text-gray-800 text-[15px] leading-loose whitespace-pre-wrap font-sans bg-transparent outline-none placeholder-gray-300"
                            placeholder="Click 'Generate Cover Letter' to let AI write your first draft, or start typing your document here manually..."
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-delete-modal show="showDeleteModal" title="Delete Cover Letter"
        description="Are you sure you want to remove this cover letter draft? This will clear the text from the document. The job application itself will not be deleted. This action cannot be undone."
        on-confirm="executeDelete" on-cancel="$set('showDeleteModal', false)" />
</div>