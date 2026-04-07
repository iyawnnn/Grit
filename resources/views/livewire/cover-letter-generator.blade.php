<div class="flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Cover Letters</h1>
            <p class="text-sm text-gray-500 mt-1">Draft, edit, and manage cover letters for your applications.</p>
        </div>
        
        @if($selectedJob)
            <a href="{{ route('applications.show', $selectedJob->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                View Application
            </a>
        @endif
    </div>

    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm p-5">
                <h2 class="text-xs font-semibold text-gray-500 mb-4 uppercase tracking-widest">Target Application</h2>
                
                <div class="space-y-5">
                    <div>
                        <select wire:model.live="jobId" id="jobId" class="w-full border-gray-200 focus:border-[#e26a35] focus:ring-[#e26a35]/20 rounded-xl shadow-sm text-sm transition-all py-2.5">
                            <option value="">-- Select an Application --</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->company }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($selectedJob)
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-medium text-gray-500">Company</span>
                                <span class="text-sm font-bold text-gray-900">{{ $selectedJob->company }}</span>
                            </div>
                            <div class="flex flex-col gap-1 mt-3">
                                <span class="text-xs font-medium text-gray-500">Role</span>
                                <span class="text-sm font-bold text-gray-900">{{ $selectedJob->title }}</span>
                            </div>
                        </div>

                        <button wire:click="generate" wire:loading.attr="disabled" class="w-full mt-2 flex items-center justify-center gap-2 py-3 px-4 bg-[#e26a35] hover:bg-[#d15a2a] text-white text-sm font-semibold rounded-xl shadow-sm shadow-[#e26a35]/20 transition-all focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50 disabled:opacity-70">
                            <span wire:loading.remove wire:target="generate" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                Generate with AI
                            </span>
                            <span wire:loading wire:target="generate" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Writing Draft...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm flex flex-col overflow-hidden h-[calc(100vh-16rem)] min-h-[550px]">
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-700">Live Editor</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if($selectedJob && $coverLetterContent)
                            <button onclick="navigator.clipboard.writeText(document.getElementById('coverLetterEditor').value); alert('Copied!')" class="text-xs font-semibold text-gray-600 hover:text-[#e26a35] px-3 py-1.5 rounded-lg transition-colors">
                                Copy Text
                            </button>
                            <button wire:click="save" class="text-xs font-semibold bg-gray-900 text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition-colors shadow-sm">
                                Save Changes
                            </button>
                        @endif
                    </div>
                </div>
                
                <div class="flex-1 relative">
                    @if($selectedJob)
                        <textarea 
                            wire:model="coverLetterContent" 
                            id="coverLetterEditor"
                            class="absolute inset-0 w-full h-full resize-none border-0 focus:ring-0 p-6 text-gray-800 text-sm leading-relaxed whitespace-pre-wrap font-sans bg-transparent custom-scrollbar"
                            placeholder="Your cover letter content will appear here. You can type manually or generate a draft using the tools on the left."
                        ></textarea>
                    @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 bg-gray-50/30">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Workspace Ready</h3>
                            <p class="text-sm text-gray-400 mt-2 max-w-sm">Select an application from the sidebar to view, edit, or generate its cover letter.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>