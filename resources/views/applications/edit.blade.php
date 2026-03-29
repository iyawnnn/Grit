<x-app-layout>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="max-w-3xl mx-auto flex flex-col gap-6 pb-12">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Edit Job Posting</h1>
                <p class="text-sm text-gray-500 mt-1">Update the details for {{ $jobPosting->company }}.</p>
            </div>
            <a href="{{ route('applications.index') }}"
                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                Cancel
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6">
            <form action="{{ route('applications.update', $jobPosting) }}" method="POST" class="space-y-6"
                x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                        <input type="text" name="title" id="title" required
                            value="{{ old('title', $jobPosting->title) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="company" id="company" required
                            value="{{ old('company', $jobPosting->company) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm">
                        @error('company')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700">Job Posting URL (Optional)</label>
                    <input type="url" name="url" id="url" value="{{ old('url', $jobPosting->url) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm">
                    @error('url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job
                        Description</label>
                    <input id="description" type="hidden" name="description"
                        value="{{ old('description', $jobPosting->description) }}">
                    <trix-editor input="description"
                        class="bg-white rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm min-h-[250px]"></trix-editor>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" x-bind:disabled="isSubmitting"
                        x-bind:class="{ 'opacity-70 cursor-not-allowed': isSubmitting }"
                        class="px-6 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center gap-2">

                        <span x-show="!isSubmitting">Save Changes</span>

                        <span x-show="isSubmitting" class="flex items-center gap-2" x-cloak>
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Updating...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>