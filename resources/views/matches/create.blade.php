<x-app-layout>
    <div class="max-w-[1200px] mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('matches.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#e26a35] transition-colors group">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-[#e26a35] transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Match Reports
            </a>
        </div>

        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">New Match Analysis</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Select a job application and resume to run the AI match.</p>
        </div>

        @livewire('create-match-report')
        
    </div>
</x-app-layout>