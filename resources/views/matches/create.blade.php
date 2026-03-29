<x-app-layout>
    <div class="max-w-3xl mx-auto flex flex-col gap-6 pb-12">

        <div class="flex items-center justify-between shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">New Match Report</h1>
                <p class="text-sm text-gray-500 mt-1">Select a job and a resume to compare.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('matches.store') }}" method="POST" class="p-6 sm:p-8 space-y-6"
                x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                @csrf

                <div>
                    <label for="job_posting_id" class="block text-sm font-semibold text-gray-900 mb-1.5">Select a Saved
                        Job</label>
                    <select name="job_posting_id" id="job_posting_id" required
                        class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm">
                        <option value="" disabled selected>Choose a job...</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}">{{ $job->title }} at {{ $job->company }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="resume_id" class="block text-sm font-semibold text-gray-900 mb-1.5">Select a
                        Resume</label>
                    <select name="resume_id" id="resume_id" required
                        class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm">
                        <option value="" disabled selected>Choose a resume...</option>
                        @foreach($resumes as $resume)
                            <option value="{{ $resume->id }}">{{ $resume->label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" x-bind:disabled="isSubmitting"
                        x-bind:class="{ 'opacity-70 cursor-not-allowed': isSubmitting }"
                        class="px-5 py-2.5 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center gap-2">

                        <span x-show="!isSubmitting">Generate Match Report</span>

                        <span x-show="isSubmitting" class="flex items-center gap-2" x-cloak>
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Analyzing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>