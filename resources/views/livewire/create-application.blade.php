<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6">
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                <input type="text" id="title" wire:model="title"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="company" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" id="company" wire:model="company"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm">
                @error('company')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="url" class="block text-sm font-medium text-gray-700">Job Posting URL (Optional)</label>
            <input type="url" id="url" wire:model="url"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm">
            @error('url')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div wire:ignore x-data="{ description: @entangle('description') }">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
            <input id="description" type="hidden">
            <trix-editor input="description"
                x-on:trix-change="description = $event.target.value"
                class="bg-white rounded-md border-gray-300 shadow-sm focus:border-[#e26a35] focus:ring-[#e26a35] sm:text-sm min-h-[250px]"></trix-editor>
        </div>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div class="flex justify-end pt-4">
            <button type="submit" wire:loading.attr="disabled"
                class="px-6 py-2 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                
                <span wire:loading.remove>Save Job Posting</span>

                <span wire:loading.flex class="items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>
    </form>
</div>