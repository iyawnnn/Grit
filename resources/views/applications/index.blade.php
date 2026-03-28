<x-app-layout>
    <div class="max-w-7xl mx-auto flex flex-col h-full">
        
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Applications</h1>
                <p class="text-sm text-gray-500 mt-1">Manage your job applications and match reports.</p>
            </div>
            <a href="{{ route('applications.create') }}" class="px-4 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Application
            </a>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-200 mb-6 shrink-0 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-sm">
            <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto custom-scrollbar pb-1 sm:pb-0">
                <button class="px-3 py-1.5 bg-gray-100 text-gray-900 rounded-md text-sm font-medium whitespace-nowrap">All</button>
                <button class="px-3 py-1.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-md text-sm font-medium transition-colors whitespace-nowrap">Interviewing</button>
                <button class="px-3 py-1.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-md text-sm font-medium transition-colors whitespace-nowrap">Pending</button>
                <button class="px-3 py-1.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-md text-sm font-medium transition-colors whitespace-nowrap">Offers</button>
            </div>

            <form method="GET" action="{{ route('applications.index') }}" class="w-full sm:w-72">
                <div class="relative flex items-center w-full h-9 rounded-md bg-gray-50 border border-gray-200 focus-within:bg-white focus-within:border-[#e26a35]/30 focus-within:ring-2 focus-within:ring-[#e26a35]/10 transition-all">
                    <div class="pl-3 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="h-full w-full outline-none text-sm text-gray-700 bg-transparent border-none focus:ring-0 pl-2 pr-4" placeholder="Search applications..." />
                </div>
            </form>
        </div>

        <div class="flex-1 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
            
            @if($applications->count() > 0)
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 font-medium">Role & Company</th>
                                <th class="px-6 py-4 font-medium">Date Applied</th>
                                <th class="px-6 py-4 font-medium text-center">Match Score</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($applications as $application)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm shrink-0">
                                                {{ substr($application->jobPosting->company ?? 'C', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $application->jobPosting->title ?? 'Untitled Role' }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $application->jobPosting->company ?? 'Unknown Company' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600">{{ $application->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $application->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold bg-[#e26a35]/10 text-[#e26a35] border border-[#e26a35]/20">
                                            {{ $application->match_score }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('applications.show', $application) }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                                            View Report
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 shrink-0">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 border border-gray-200 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">No applications found</h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-sm">You haven't tracked any job applications yet. Start by generating a match report against a job description.</p>
                    <button class="mt-6 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm">
                        Create your first entry
                    </button>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>