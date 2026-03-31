<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <div class="max-w-6xl mx-auto flex flex-col h-full gap-6">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Your career data overview.</p>
            </div>
            <a href="{{ route('matches.create') }}"
                class="px-4 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Match Report
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 shrink-0">

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col justify-center">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Resumes</p>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-bold text-gray-900">{{ $totalResumes }}</span>
                    <a href="{{ route('resumes.index') }}"
                        class="text-sm text-[#e26a35] hover:underline mb-1">Manage</a>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col justify-center">
                <p class="text-sm font-medium text-gray-500 mb-1">Match Reports</p>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-bold text-gray-900">{{ $totalReports }}</span>
                    <a href="{{ route('matches.index') }}" class="text-sm text-[#e26a35] hover:underline mb-1">View
                        all</a>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col justify-center">
                <p class="text-sm font-medium text-gray-500 mb-1">Average Match Score</p>
                <div class="flex items-end gap-3">
                    <span
                        class="text-3xl font-bold {{ $averageScore > 70 ? 'text-green-600' : 'text-gray-900' }}">{{ $averageScore }}%</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-base font-semibold text-gray-900">Recent Reports</h2>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($recentReports as $report)
                        <div
                            class="p-6 hover:bg-gray-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">
                                    {{ $report->jobPosting->title ?? 'Deleted Job' }}</h3>
                                <p class="text-xs text-gray-500 mt-1">Matched with:
                                    {{ $report->resume->label ?? 'Deleted Resume' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $report->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex items-center gap-4 shrink-0">
                                <span
                                    class="px-3 py-1 rounded-md text-xs font-bold {{ $report->score > 70 ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-700 border border-gray-200' }}">
                                    {{ $report->score }}% Match
                                </span>
                                <a href="{{ route('matches.show', $report) }}"
                                    class="text-sm font-medium text-[#e26a35] hover:text-[#cf5b29]">View Report</a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <p class="text-sm text-gray-500">You have not generated any match reports yet.</p>
                            <a href="{{ route('matches.create') }}"
                                class="inline-block mt-3 text-sm font-medium text-[#e26a35] hover:underline">Create your
                                first report</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Profile Strength</h2>

                <div class="flex items-center justify-between mb-2">
                    <span class="text-3xl font-bold text-gray-900">{{ $profileStrength }}%</span>
                </div>

                <div class="w-full bg-gray-100 rounded-full h-2.5 mb-4 overflow-hidden">
                    <div class="bg-[#e26a35] h-2.5 rounded-full transition-all duration-500"
                        style="width: {{ $profileStrength }}%"></div>
                </div>

                @if($profileStrength < 100)
                    <p class="text-sm text-gray-600 font-medium mb-1">Keep improving</p>
                    <p class="text-xs text-gray-500">Upload more tailored resumes and run match reports to increase your
                        overall strength metric.</p>
                @else
                    <p class="text-sm text-green-600 font-medium mb-1">Excellent Profile!</p>
                    <p class="text-xs text-gray-500">Your tailored resumes are generating high match scores.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>