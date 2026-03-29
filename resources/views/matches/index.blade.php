<x-app-layout>
    <div class="max-w-6xl mx-auto flex flex-col h-full gap-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Match Reports</h1>
                <p class="text-sm text-gray-500 mt-1">View your AI analysis and match scores.</p>
            </div>
            <a href="{{ route('matches.create') }}" class="px-4 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Match Report
            </a>
        </div>

        <div class="flex-1 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
            @if($matches->count() > 0)
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 font-medium">Target Role</th>
                                <th class="px-6 py-4 font-medium">Resume Used</th>
                                <th class="px-6 py-4 font-medium text-center">Score</th>
                                <th class="px-6 py-4 font-medium">Date</th>
                                <th class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($matches as $match)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900">{{ $match->jobPosting->title ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $match->jobPosting->company ?? 'Unknown' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $match->resume->label ?? 'Deleted Resume' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold bg-[#e26a35]/10 text-[#e26a35] border border-[#e26a35]/20">
                                            {{ $match->score }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $match->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('matches.show', $match) }}" class="text-sm font-medium text-[#e26a35] hover:text-[#cf5b29]">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 shrink-0">
                    {{ $matches->links() }}
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 border border-gray-200 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">No match reports</h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-sm">You have not generated any AI match reports yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>