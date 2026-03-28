<x-app-layout>
    <div class="max-w-7xl mx-auto">

        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Your career data overview.</p>
            </div>
            <a href="{{ route('applications.create') }}"
                class="px-4 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Application
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-xl p-6 border border-gray-200 flex flex-col">
                <h2 class="text-sm font-medium text-gray-500">Total Resumes</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $totalResumes ?? '0' }}</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 flex flex-col">
                <h2 class="text-sm font-medium text-gray-500">Match Reports</h2>
                <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $totalMatches ?? '0' }}</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 flex flex-col">
                <h2 class="text-sm font-medium text-gray-500">Average Match Score</h2>
                <div class="mt-2 flex items-baseline gap-1">
                    <p class="text-3xl font-semibold text-gray-900">{{ number_format($averageScore ?? 0, 0) }}</p>
                    <span class="text-lg text-gray-500 font-medium">%</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 flex flex-col min-h-[400px]">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-900">Recent Reports</h2>
                </div>

                <div class="flex-1 p-6">
                    @if(isset($recentActivity) && $recentActivity->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentActivity as $report)
                                <div
                                    class="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $report->jobPosting->title ?? 'Untitled Role' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $report->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span
                                        class="px-2.5 py-1 bg-gray-50 border border-gray-200 text-gray-700 rounded text-xs font-medium">
                                        {{ $report->match_score }}% Match
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center py-12">
                            <div
                                class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center mb-3 border border-gray-200 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-gray-900">No data available</h3>
                            <p class="text-sm text-gray-500 mt-1">Upload a resume to begin tracking matches.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col">
                <h2 class="text-sm font-semibold text-gray-900 mb-6">Profile Strength</h2>

                <div class="flex-1 flex flex-col items-center justify-center text-center">
                    <div class="relative w-32 h-32 mb-6">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-100" stroke-width="2.5" stroke="currentColor" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-[#e26a35]" stroke-dasharray="{{ $averageScore ?? 0 }}, 100"
                                stroke-width="2.5" stroke-linecap="round" stroke="currentColor" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span
                                class="text-2xl font-semibold text-gray-900">{{ number_format($averageScore ?? 0, 0) }}%</span>
                        </div>
                    </div>

                    <h3 class="text-sm font-medium text-gray-900">Keep improving</h3>
                    <p class="text-xs text-gray-500 mt-1">Tailor your resume to increase this metric.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>