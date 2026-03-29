<x-app-layout>
    <div class="max-w-4xl mx-auto flex flex-col gap-6 pb-12">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Job Details</h1>
                <p class="text-sm text-gray-500 mt-1">Review the information for this application.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('applications.index') }}"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                    Back to Jobs
                </a>
                <a href="{{ route('applications.edit', $jobPosting) }}"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-medium hover:bg-emerald-700 transition-colors shadow-sm">
                    Edit Job
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Role</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $jobPosting->title }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Company</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $jobPosting->company }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Date Saved</h3>
                    <p class="mt-1 text-base text-gray-900">{{ $jobPosting->created_at->format('F d, Y') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Job URL</h3>
                    @if($jobPosting->url)
                        <a href="{{ $jobPosting->url }}" target="_blank" rel="noopener noreferrer"
                            class="mt-1 inline-block text-base text-[#e26a35] hover:underline">
                            Open External Link
                        </a>
                    @else
                        <p class="mt-1 text-base text-gray-400">No URL provided</p>
                    @endif
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-3">Job Description</h3>
                <div class="prose prose-sm max-w-none text-gray-700">
                    {!! $jobPosting->description !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>