<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <div class="relative w-full max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by role, company, or resume..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#e26a35] focus:border-[#e26a35] sm:text-sm transition duration-150 ease-in-out">
        </div>
    </div>

    <div class="flex-1 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col relative">
        
        <div wire:loading.flex class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 flex items-center justify-center">
            <svg class="animate-spin h-6 w-6 text-[#e26a35]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

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
                                    @if($match->status === 'processing')
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                            Processing
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold bg-[#e26a35]/10 text-[#e26a35] border border-[#e26a35]/20">
                                            {{ $match->score }}%
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $match->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-4">
                                        <a href="{{ route('matches.show', $match) }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">View</a>
                                        <button type="button" 
                                                wire:click="deleteReport({{ $match->id }})"
                                                wire:confirm="Are you sure you want to delete this report?"
                                                class="text-sm font-medium text-red-600 hover:text-red-800">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($matches->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 shrink-0">
                    {{ $matches->links() }}
                </div>
            @endif
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 border border-gray-200 text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">No match reports found</h3>
                <p class="text-sm text-gray-500 mt-1 max-w-sm">Try adjusting your search or generate a new report.</p>
            </div>
        @endif
    </div>
</div>