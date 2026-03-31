<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col h-[calc(100vh-10rem)] min-h-[600px] gap-6">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 shrink-0 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <a href="{{ route('resumes.index') }}"
                        class="p-2.5 text-gray-500 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ $resume->label }}</h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="flex w-2 h-2 bg-[#e26a35] rounded-full"></span>
                            <p class="text-sm text-gray-500 font-medium">Uploaded on {{ $resume->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="{{ $resume->file_url }}" target="_blank" rel="noopener noreferrer"
                        class="flex w-full sm:w-auto items-center justify-center gap-2 px-5 py-2.5 bg-[#e26a35] text-white rounded-xl text-sm font-semibold hover:bg-[#cf5b29] transition-colors focus:ring-2 focus:ring-[#e26a35]/20 focus:outline-none shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Open Original File
                    </a>
                </div>
            </div>

            <div class="flex-1 bg-gray-50 rounded-2xl border border-gray-200 shadow-sm overflow-hidden relative group">
                <div class="absolute inset-0 flex items-center justify-center z-0">
                    <div class="flex flex-col items-center gap-3 animate-pulse">
                        <div class="w-8 h-8 border-4 border-[#e26a35]/30 border-t-[#e26a35] rounded-full animate-spin"></div>
                        <span class="text-sm font-medium text-gray-500">Loading document...</span>
                    </div>
                </div>

                <iframe 
                    src="{{ $resume->file_url }}#view=FitH&toolbar=0&navpanes=0" 
                    class="absolute inset-0 w-full h-full border-0 bg-transparent z-10"
                    title="{{ $resume->label }} Document Viewer">
                </iframe>
            </div>

        </div>
    </div>
</x-app-layout>