<div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-extrabold text-gray-900 tracking-tight">Job Details</h3>
    </div>
    
    <form wire:submit.prevent="save" class="p-4 sm:p-8 space-y-6 sm:space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-extrabold text-gray-900 mb-2">Job Title</label>
                <input type="text" id="title" wire:model="title" placeholder="e.g. Senior Full Stack Developer"
                    class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all outline-none shadow-sm">
                @error('title') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="company" class="block text-sm font-extrabold text-gray-900 mb-2">Company Name</label>
                <input type="text" id="company" wire:model="company" placeholder="e.g. Acme Corp"
                    class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all outline-none shadow-sm">
                @error('company') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="url" class="block text-sm font-extrabold text-gray-900 mb-2">Job Posting URL <span class="text-gray-400 font-medium">(Optional)</span></label>
            <input type="url" id="url" wire:model="url" placeholder="https://..."
                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all outline-none shadow-sm">
            @error('url') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
        </div>

        <div wire:ignore x-data="{ 
            description: @entangle('description'),
            init() {
                window.addEventListener('description-formatted', (event) => {
                    this.$refs.trix.editor.loadHTML(event.detail.html);
                });
            }
        }">
            <div class="flex items-center justify-between mb-2">
                <label for="description" class="block text-sm font-extrabold text-gray-900">Job Description</label>
                
                <button type="button" wire:click="autoFormatDescription" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#fff5f0] text-[#e26a35] border border-[#e26a35]/20 rounded-lg text-xs font-bold hover:bg-[#ffece4] transition-colors focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50 disabled:opacity-50 disabled:cursor-wait">
                    
                    <x-heroicon-o-sparkles wire:loading.remove wire:target="autoFormatDescription" class="w-4 h-4" />
                    <svg wire:loading wire:target="autoFormatDescription" class="animate-spin h-4 w-4 text-[#e26a35]" xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    
                    <span wire:loading.remove wire:target="autoFormatDescription">Auto Format</span>
                    <span wire:loading wire:target="autoFormatDescription">Formatting...</span>
                </button>
            </div>
            
            <input id="description" type="hidden">
            
            <div class="rounded-xl border border-gray-300 shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-[#e26a35]/50 focus-within:border-[#e26a35] transition-all group">
                <trix-editor x-ref="trix" input="description"
                    x-on:trix-change="description = $event.target.value"
                    class="trix-content border-none outline-none min-h-[200px]"></trix-editor>
            </div>
        </div>
        @error('description') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror

        <div class="pt-6 border-t border-gray-100 flex justify-end shrink-0">
            <button type="submit" wire:loading.attr="disabled" wire:target="save"
                class="w-full md:w-auto px-8 py-3.5 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 shadow-sm flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                
                <span wire:loading.remove wire:target="save">Save Job Posting</span>

                <span wire:loading.flex wire:target="save" class="items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>
    </form>
</div>