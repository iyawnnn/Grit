<div class="flex flex-col gap-8">
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Upload New Resume</h2>
        <form wire:submit="save" class="flex flex-col sm:flex-row items-start gap-4">
            
            <div class="w-full sm:w-1/3">
                <label for="label" class="block text-sm font-medium text-gray-700 mb-1">Resume Label</label>
                <input type="text" id="label" wire:model="label" placeholder="e.g. Frontend Developer 2026"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm">
                @error('label') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="w-full sm:w-1/3">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">PDF File</label>
                <input type="file" id="file" wire:model="file" accept=".pdf"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#e26a35]/10 file:text-[#e26a35] hover:file:bg-[#e26a35]/20 transition-colors">
                @error('file') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="w-full sm:w-auto self-start sm:self-end sm:mt-[24px]">
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full sm:w-auto px-6 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="save">Upload & Parse</span>
                    <span wire:loading.flex wire:target="save" class="items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing PDF...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Added</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 relative">
                    
                    <div wire:loading.flex wire:target="deleteResume, gotoPage, nextPage, previousPage" class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 flex items-center justify-center">
                        <svg class="animate-spin h-6 w-6 text-[#e26a35]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    @forelse($resumes as $resume)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="{{ $resume->file_url }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $resume->label }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $resume->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-4">
                                    <a href="{{ route('resumes.show', $resume) }}" class="text-gray-500 hover:text-gray-900 transition-colors">
                                        View Data
                                    </a>
                                    <button type="button" 
                                            wire:click="deleteResume({{ $resume->id }})"
                                            wire:confirm="Are you sure you want to delete this resume? This will also remove it from Cloudinary."
                                            class="text-red-600 hover:text-red-800 transition-colors">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500">
                                No resumes uploaded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($resumes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $resumes->links() }}
            </div>
        @endif
    </div>
</div>