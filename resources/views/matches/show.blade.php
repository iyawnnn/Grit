<x-app-layout>
    <div class="max-w-6xl mx-auto flex flex-col gap-6 pb-12">

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between shrink-0 gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('matches.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-900 bg-white border border-gray-200 rounded-md transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                        {{ $matchReport->jobPosting->title ?? 'Untitled Role' }}
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">{{ $matchReport->jobPosting->company ?? 'Unknown Company' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('matches.updateStatus', $matchReport) }}" method="POST" class="m-0">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()"
                        class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm cursor-pointer focus:ring-[#e26a35] focus:border-[#e26a35]">
                        <option value="pending" {{ $matchReport->status === 'pending' ? 'selected' : '' }}>⏳ Pending
                        </option>
                        <option value="applied" {{ $matchReport->status === 'applied' ? 'selected' : '' }}>✅ Applied
                        </option>
                        <option value="interviewing" {{ $matchReport->status === 'interviewing' ? 'selected' : '' }}>💬
                            Interviewing</option>
                        <option value="offered" {{ $matchReport->status === 'offered' ? 'selected' : '' }}>🎉 Offered
                        </option>
                        <option value="rejected" {{ $matchReport->status === 'rejected' ? 'selected' : '' }}>❌ Rejected
                        </option>
                    </select>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#e26a35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Match Analysis
                    </h2>

                    <div class="prose prose-sm max-w-none text-gray-600">
                        @if($matchReport->reasoning)
                            {!! Str::markdown($matchReport->reasoning) !!}
                        @else
                            <p class="text-gray-500 italic">Analysis pending or unavailable.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Original Job Description</h2>
                    <div
                        class="bg-gray-50 rounded-lg p-5 border border-gray-100 max-h-[500px] overflow-y-auto custom-scrollbar">
                        <div class="prose prose-sm prose-gray max-w-none">
                            {!! $matchReport->jobPosting->description ?? 'No description provided.' !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 sticky top-6">

                <div
                    class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col items-center text-center">
                    <h2 class="text-sm font-semibold text-gray-900 mb-6 w-full text-left">Overall Score</h2>

                    <div class="relative w-36 h-36 mb-6">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-100" stroke-width="3" stroke="currentColor" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-[#e26a35]" stroke-dasharray="{{ $matchReport->score ?? 0 }}, 100"
                                stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-4xl font-bold text-gray-900">{{ $matchReport->score ?? 0 }}</span>
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Match</span>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500">Generated on {{ $matchReport->created_at->format('M d, Y') }}</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-gray-900 mb-4">Resume Used</h2>

                    @if($matchReport->resume)
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100 mb-4">
                            <div
                                class="w-8 h-8 rounded bg-white border border-gray-200 flex items-center justify-center text-gray-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $matchReport->resume->label }}</p>
                                <p class="text-xs text-gray-500 truncate">Document ID: {{ $matchReport->resume->id }}</p>
                            </div>
                        </div>

                        <a href="{{ route('resumes.show', $matchReport->resume) }}"
                            class="w-full flex items-center justify-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                            View Resume
                        </a>
                    @else
                        <p class="text-sm text-gray-500">No resume is linked to this report.</p>
                    @endif
                </div>

                <div class="pt-4">
                    <form action="{{ route('matches.destroy', $matchReport) }}" method="POST"
                        x-data="{ isDeleting: false }"
                        @submit="isDeleting = true; return confirm('Are you sure you want to delete this match report? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" x-bind:disabled="isDeleting"
                            x-bind:class="{ 'opacity-50 cursor-not-allowed': isDeleting }"
                            class="w-full flex items-center justify-center gap-2 text-sm font-medium text-red-500 hover:text-red-700 transition-colors">

                            <span x-show="!isDeleting">Delete Report</span>
                            <span x-show="isDeleting" x-cloak>Deleting...</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>