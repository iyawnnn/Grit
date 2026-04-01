<x-app-layout>
    <x-slot:title>Edit Job Posting</x-slot:title>
    
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 relative">
        
        <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 mb-10">
            <div class="flex flex-col items-center md:items-start w-full md:w-auto">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                    <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20">
                        <x-heroicon-o-briefcase class="w-6 h-6 text-[#e26a35]" />
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Edit Job Posting</h1>
                </div>
                <p class="text-base font-medium text-gray-500 max-w-sm mx-auto md:mx-0">Update the details of your saved job posting.</p>
            </div>
            
            <a href="{{ route('applications.show', $jobPosting->id) }}"
                class="w-full md:w-auto justify-center px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl text-sm font-bold tracking-tight hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm inline-flex items-center gap-2">
                <x-heroicon-o-arrow-left class="w-5 h-5" />
                Back to Application
            </a>
        </div>

        <livewire:edit-application :jobPosting="$jobPosting" />
        
    </div>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
        trix-toolbar {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
            margin-bottom: 0 !important;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        trix-toolbar .trix-button-group {
            margin-bottom: 0;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: white;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        }
        trix-toolbar .trix-button {
            border-bottom: none;
            background: transparent;
            transition: all 0.2s;
        }
        trix-toolbar .trix-button:not(:first-child) {
            border-left: 1px solid #e5e7eb;
        }
        trix-toolbar .trix-button:hover {
            background-color: #f3f4f6;
        }
        trix-toolbar .trix-button.trix-active {
            background: #fff5f0;
            color: #e26a35;
        }
        trix-editor {
            background-color: #ffffff;
            min-height: 350px;
            padding: 1.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        @media (max-width: 640px) {
            trix-editor {
                padding: 1rem;
                min-height: 250px;
            }
        }
    </style>
</x-app-layout>