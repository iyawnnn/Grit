<x-app-layout>
    <div class="max-w-6xl mx-auto flex flex-col h-full gap-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Saved Jobs</h1>
                <p class="text-sm text-gray-500 mt-1">Job postings you are currently tracking.</p>
            </div>
            <a href="{{ route('applications.create') }}"
                class="px-4 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Job Posting
            </a>
        </div>

        <div class="flex-1 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
            @if($jobs->count() > 0)
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 font-medium">Role & Company</th>
                                <th class="px-6 py-4 font-medium">Date Added</th>
                                <th class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($jobs as $job)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900">{{ $job->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $job->company }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $job->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-4">
                                            <a href="{{ $job->url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                                class="text-sm font-medium text-[#e26a35] hover:text-[#cf5b29] {{ !$job->url ? 'invisible' : '' }}">
                                                Job Link
                                            </a>

                                            <a href="{{ route('applications.show', $job) }}"
                                                class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                                View
                                            </a>

                                            <a href="{{ route('applications.edit', $job) }}"
                                                class="text-sm font-medium text-emerald-600 hover:text-emerald-800 transition-colors">
                                                Edit
                                            </a>

                                            <form action="{{ route('applications.destroy', $job) }}" method="POST"
                                                class="m-0 p-0"
                                                onsubmit="return confirm('Are you sure you want to delete this job posting?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-sm font-medium text-gray-400 hover:text-red-500 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 shrink-0">
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                    <div
                        class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 border border-gray-200 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">No jobs tracked</h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-sm">Save a job posting to track it.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>