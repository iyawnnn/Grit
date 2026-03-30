<x-app-layout>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="max-w-3xl mx-auto flex flex-col gap-6 pb-12">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Edit Job Posting</h1>
                <p class="text-sm text-gray-500 mt-1">Update the details of this job application.</p>
            </div>
            <a href="{{ route('applications.index') }}"
                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                Cancel
            </a>
        </div>

        <livewire:edit-application :job-posting="$jobPosting" />
        
    </div>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
</x-app-layout>