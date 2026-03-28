<x-app-layout>
    <div class="max-w-6xl mx-auto flex flex-col h-full gap-6">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Resumes</h1>
                <p class="text-sm text-gray-500 mt-1">Manage and store your tailored resumes.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-sm font-semibold text-gray-900 mb-4">Upload New Document</h2>

            <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col sm:flex-row gap-4 items-end">
                @csrf

                <div class="w-full sm:w-1/3">
                    <label for="label"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Document
                        Label</label>
                    <input type="text" name="label" id="label" required placeholder="Frontend Dev Resume"
                        class="w-full h-9 rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                </div>

                <div class="w-full sm:w-1/2">
                    <label for="file"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">PDF
                        File</label>
                    <input type="file" name="file" id="file" accept=".pdf" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors cursor-pointer">
                </div>

                <button type="submit"
                    class="h-9 px-4 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors w-full sm:w-auto flex items-center justify-center">
                    Upload
                </button>
            </form>

            @error('file')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-1 bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col">
            @if($resumes->count() > 0)
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50/50">
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">File Name
                                </th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date
                                    Added</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($resumes as $resume)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded border border-gray-200 flex items-center justify-center text-gray-400 bg-white">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $resume->label }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="text-sm text-gray-500">{{ $resume->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <div class="flex items-center justify-end gap-4">

                                            <a href="{{ route('resumes.show', $resume) }}"
                                                class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                                                View
                                            </a>

                                            <form action="{{ route('resumes.destroy', $resume) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this resume? This action cannot be undone.');"
                                                class="inline-block m-0 p-0">
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

                @if($resumes->hasPages())
                    <div class="px-6 py-3 border-t border-gray-200 bg-gray-50">
                        {{ $resumes->links() }}
                    </div>
                @endif
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                    <div
                        class="w-10 h-10 rounded border border-gray-200 flex items-center justify-center text-gray-400 bg-gray-50 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">No documents yet</h3>
                    <p class="text-sm text-gray-500 mt-1">Upload your first resume using the form above.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>