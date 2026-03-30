<x-app-layout>
    <div class="max-w-3xl mx-auto flex flex-col gap-6 pb-12">

        <div class="flex items-center justify-between shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">New Match Report</h1>
                <p class="text-sm text-gray-500 mt-1">Select a job and a resume to compare.</p>
            </div>
        </div>

        <livewire:create-match-report />
        
    </div>
</x-app-layout>