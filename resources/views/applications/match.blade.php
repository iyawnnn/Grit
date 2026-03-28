<x-app-layout>
    <div class="max-w-3xl mx-auto flex flex-col h-full gap-6">

        <div class="flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('applications.create') }}"
                    class="p-2 text-gray-400 hover:text-gray-900 bg-white border border-gray-200 rounded-md transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Step 2: Select Resume</h1>
                    <p class="text-sm text-gray-500 mt-1">Choose the resume you want the AI to analyze.</p>
                </div>
            </div>
            <div class="text-sm font-medium text-gray-400">
                2 of 2
            </div>
        </div>

        <div
            class="bg-gray-50 rounded-xl border border-gray-200 p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Target Role</p>
                <h3 class="text-lg font-bold text-gray-900">{{ $jobPosting->title }}</h3>
                <p class="text-sm text-gray-500">{{ $jobPosting->company }}</p>
            </div>
            <div class="p-3 bg-white rounded-lg border border-gray-200 shadow-sm shrink-0">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('applications.storeMatch', $jobPosting) }}" method="POST"
                class="p-6 sm:p-8 space-y-6">
                @csrf

                <div>
                    <label for="resume_id" class="block text-sm font-semibold text-gray-900 mb-1.5">Your Uploaded
                        Resumes</label>
                    <select name="resume_id" id="resume_id" required
                        class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                        <option value="" disabled selected>Select a resume...</option>
                        @foreach($resumes as $resume)
                            <option value="{{ $resume->id }}">{{ $resume->label }} (Uploaded
                                {{ $resume->created_at->format('M d') }})</option>
                        @endforeach
                    </select>
                    @error('resume_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('resumes.index') }}"
                        class="text-sm font-medium text-[#e26a35] hover:text-[#cf5b29]">
                        + Upload new resume
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Analyze Match
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>