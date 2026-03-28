<x-app-layout>
    <div class="max-w-6xl mx-auto flex flex-col h-[calc(100vh-8rem)] gap-6">

        <div class="flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('resumes.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-900 bg-white border border-gray-200 rounded-md transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-gray-900">{{ $resume->label }}</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Uploaded {{ $resume->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ $resume->file_url }}" target="_blank"
                    class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                    Open in New Tab
                </a>
            </div>
        </div>

        <div class="flex-1 bg-gray-200 rounded-xl border border-gray-200 overflow-hidden shadow-inner relative">
            <object data="{{ $resume->file_url }}#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf"
                class="absolute inset-0 w-full h-full">
                <div class="flex flex-col items-center justify-center h-full bg-white text-center p-8">
                    <p class="text-gray-500 text-sm mb-4">Your browser does not support inline PDFs.</p>
                    <a href="{{ $resume->file_url }}" target="_blank"
                        class="px-4 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29]">
                        Download PDF
                    </a>
                </div>
            </object>
        </div>

    </div>
</x-app-layout>