<x-app-layout>
    <x-slot:title>Match Reports</x-slot:title>
    <div class="max-w-6xl mx-auto flex flex-col gap-6 pb-12">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Match Reports</h1>
                <p class="text-sm text-gray-500 mt-1">View your AI analysis and match scores.</p>
            </div>
            <a href="{{ route('matches.create') }}" class="px-4 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Match Report
            </a>
        </div>

        <livewire:match-report-index />

    </div>
</x-app-layout>