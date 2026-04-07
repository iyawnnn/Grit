<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 relative"
    x-data="{ showUpload: false, showDeleteModal: false }"
    @keydown.window.escape="showUpload = false; showDeleteModal = false"
    @close-slide-over.window="showUpload = false">

    <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 mb-10">
        <div class="flex flex-col items-center md:items-start w-full md:w-auto">
            <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20">
                    <x-heroicon-o-document-text class="w-6 h-6 text-[#e26a35]" />
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Resume Library</h1>
            </div>
            <p class="text-base font-medium text-gray-500 max-w-sm mx-auto md:mx-0">Manage your documents for AI matching and applications.</p>
        </div>
        <button type="button" @click="showUpload = true"
            class="w-full md:w-auto justify-center px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
            <x-heroicon-o-cloud-arrow-up class="w-5 h-5" />
            Upload Resume
        </button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8 z-10 relative">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-document-duplicate class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Uploaded</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalResumes }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-s-star class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Primary Resume</p>
                <p class="text-lg font-extrabold text-gray-900 tracking-tight truncate">
                    {{ $primaryResume ? $primaryResume->label : 'Not set' }}
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-clock class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Latest Upload</p>
                <p class="text-lg font-extrabold text-gray-900 tracking-tight">
                    {{ $latestResume ? $latestResume->created_at->format('M d, Y') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-8 z-30 relative">
        <div class="relative w-full md:flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search resumes..."
                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white text-sm font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
        </div>

        <div x-data="{ 
                open: false, 
                currentSort: @entangle('sort').live,
                get sortLabel() {
                    if (this.currentSort === 'newest') return 'Newest First';
                    if (this.currentSort === 'oldest') return 'Oldest First';
                    if (this.currentSort === 'name') return 'Name (A-Z)';
                    return 'Sort by';
                }
            }" class="relative w-full md:w-64 shrink-0">

            <button type="button" @click="open = !open" @click.outside="open = false"
                class="w-full flex justify-between items-center px-4 py-3.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none cursor-pointer">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-arrows-up-down class="w-4 h-4 text-gray-400" />
                    <span class="font-bold text-gray-700" x-text="sortLabel"></span>
                </div>
                <x-heroicon-o-chevron-down class="h-4 w-4 text-gray-400 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <div x-show="open" x-cloak x-transition.opacity style="display: none;"
                class="absolute right-0 mt-2 w-full rounded-xl bg-white shadow-xl border border-gray-100 overflow-hidden py-2 z-50">
                <button type="button" wire:click.prevent="$set('sort', 'newest')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-bold transition-colors"
                    :class="currentSort === 'newest' ? 'bg-[#fff5f0] text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50'">
                    Newest First
                </button>
                <button type="button" wire:click.prevent="$set('sort', 'oldest')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-bold transition-colors"
                    :class="currentSort === 'oldest' ? 'bg-[#fff5f0] text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50'">
                    Oldest First
                </button>
                <button type="button" wire:click.prevent="$set('sort', 'name')" @click="open = false"
                    class="w-full text-left px-5 py-2.5 text-sm font-bold transition-colors"
                    :class="currentSort === 'name' ? 'bg-[#fff5f0] text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50'">
                    Name (A-Z)
                </button>
            </div>
        </div>
    </div>

    <div class="relative min-h-[400px] z-10">
        <div wire:loading.grid wire:target="search, sort, gotoPage" class="absolute inset-0 z-10 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 bg-[#f9fafb]">
            @for ($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col h-full animate-pulse">
                <div class="h-6 w-3/4 bg-gray-200 rounded-md mb-4"></div>
                <div class="h-4 w-1/2 bg-gray-100 rounded-md mb-8"></div>
            </div>
            @endfor
        </div>

        <div wire:loading.remove wire:target="search, sort, gotoPage">
            @if($resumes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($resumes as $resume)
                <div wire:key="resume-card-{{ $resume->id }}"
                    class="bg-white rounded-2xl border shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col p-6 group h-full {{ $resume->is_primary ? 'border-[#e26a35]/40 ring-1 ring-[#e26a35]/10' : 'border-gray-200 hover:border-[#e26a35]/40' }}">

                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 group-hover:bg-[#fff5f0] group-hover:border-[#e26a35]/20 transition-colors shrink-0">
                            <x-heroicon-o-identification class="w-6 h-6 text-gray-400 group-hover:text-[#e26a35] transition-colors" />
                        </div>

                        <button type="button" wire:click="togglePrimary({{ $resume->id }})"
                            class="p-1 rounded-md transition-colors focus:outline-none flex items-center justify-center"
                            title="{{ $resume->is_primary ? 'Remove Primary Status' : 'Set as Primary' }}">

                            <div wire:loading wire:target="togglePrimary({{ $resume->id }})">
                                <svg class="animate-spin h-6 w-6 text-[#e26a35]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>

                            <div wire:loading.remove wire:target="togglePrimary({{ $resume->id }})">
                                @if($resume->is_primary)
                                <x-heroicon-s-star class="w-6 h-6 text-[#e26a35]" />
                                @else
                                <x-heroicon-o-star class="w-6 h-6 text-gray-300 hover:text-gray-400 hover:scale-110 transition-transform" />
                                @endif
                            </div>
                        </button>
                    </div>

                    <div class="mb-6 flex-1 pr-2">
                        <h3 class="text-xl font-extrabold text-gray-900 leading-tight mb-2 group-hover:text-[#e26a35] transition-colors truncate">
                            {{ $resume->label }}
                        </h3>
                        <div class="flex items-center gap-1.5 text-xs font-bold text-gray-400">
                            <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                            {{ $resume->created_at->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="pt-5 border-t border-gray-100 flex items-center justify-between mt-auto shrink-0">

                        <a href="{{ route('resumes.show', $resume) }}" class="text-sm font-bold text-gray-500 hover:text-[#e26a35] transition-colors flex items-center gap-1.5">
                            <x-heroicon-s-document-text class="w-4 h-4" /> View Details
                        </a>

                        <button type="button" @click="$wire.confirmDelete({{ $resume->id }}); showDeleteModal = true"
                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0" title="Delete">
                            <x-heroicon-o-trash class="w-5 h-5" />
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            @if($resumes->hasPages())
            <div class="mt-10 custom-pagination">
                {{ $resumes->links() }}
            </div>
            @endif
            @else
                @if(!$hasAnyResumes)
                <div class="w-full bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center text-center p-16 sm:p-24 shadow-sm">
                    <div class="w-20 h-20 bg-[#fff5f0] rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-[#e26a35]/10">
                        <x-heroicon-o-document-arrow-up class="w-10 h-10 text-[#e26a35]" />
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">No resumes uploaded</h3>
                    <p class="text-base font-medium text-gray-500 max-w-md mx-auto mb-8">
                        Upload your first PDF resume to let the system parse your experience and start matching with roles.
                    </p>
                    <button type="button" @click="showUpload = true"
                        class="px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
                        <x-heroicon-o-cloud-arrow-up class="w-5 h-5" />
                        Upload First Resume
                    </button>
                </div>
                @else
                <div class="w-full bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center text-center p-16 sm:p-24 shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-gray-200">
                        <x-heroicon-o-magnifying-glass class="w-10 h-10 text-gray-400" />
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">No matching resumes</h3>
                    <p class="text-base font-medium text-gray-500 max-w-md mx-auto mb-8">
                        We couldn't find any documents matching your current search or sort filters.
                    </p>
                    <button type="button" wire:click.prevent="$set('search', '')"
                        class="px-6 py-3 bg-white text-gray-900 border border-gray-300 rounded-xl text-sm font-bold hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm flex items-center gap-2">
                        <x-heroicon-m-arrow-path class="w-5 h-5 text-gray-500" />
                        Clear Search
                    </button>
                </div>
                @endif
            @endif
        </div>
    </div>

    <div x-show="showUpload" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" style="display: none;" x-cloak>
        <div x-show="showUpload" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="showUpload" @click.away="showUpload = false" x-transition:enter="transform transition ease-in-out duration-300 sm:duration-400" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300 sm:duration-400" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl border-l border-gray-200">
                            <div class="px-6 py-6 sm:px-8 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                                <h2 class="text-lg font-extrabold text-gray-900 tracking-tight" id="slide-over-title">Upload Resume</h2>
                                <button type="button" @click="showUpload = false" class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#e26a35]">
                                    <span class="sr-only">Close panel</span>
                                    <x-heroicon-o-x-mark class="h-6 w-6" />
                                </button>
                            </div>

                            <div class="relative flex-1 px-6 py-6 sm:px-8">
                                <form wire:submit="save" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="flex flex-col gap-6">
                                    <div>
                                        <label for="label" class="block text-sm font-bold text-gray-700 mb-2">Resume Label</label>
                                        <input type="text" id="label" wire:model="label" placeholder="e.g. Senior Developer 2026"
                                            class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm focus:border-[#e26a35] focus:ring-[#e26a35] transition-colors outline-none font-medium">
                                        @error('label') <span class="text-red-600 text-xs mt-1.5 font-bold block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">PDF Document</label>

                                        <div class="relative">
                                            <div class="mt-1 flex justify-center rounded-xl border border-dashed border-gray-300 px-6 py-10 hover:bg-gray-50 transition-colors overflow-hidden relative"
                                                :class="{ 'bg-gray-50 border-[#e26a35]': uploading }">

                                                <div x-show="uploading" class="absolute bottom-0 left-0 h-1 bg-[#e26a35] transition-all duration-200" :style="`width: ${progress}%`" x-cloak></div>

                                                <div class="text-center relative z-10">
                                                    <x-heroicon-o-document-arrow-up class="mx-auto h-10 w-10 transition-colors" x-bind:class="uploading ? 'text-[#e26a35] animate-pulse' : 'text-gray-300'" />

                                                    <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-bold text-[#e26a35] focus-within:outline-none hover:text-[#cf5b29]">
                                                            <span x-text="uploading ? 'Uploading...' : 'Select a file'"></span>
                                                            <input id="file-upload" wire:model.live="file" type="file" accept=".pdf" class="sr-only" :disabled="uploading">
                                                        </label>
                                                    </div>
                                                    <p class="text-xs font-medium text-gray-500 mt-1" x-show="!uploading">PDF up to 5MB</p>
                                                    <p class="text-xs font-bold text-[#e26a35] mt-1" x-show="uploading" x-text="`${progress}%`" x-cloak></p>
                                                </div>
                                            </div>

                                            @error('file') <span class="text-red-600 text-xs mt-1.5 font-bold block">{{ $message }}</span> @enderror

                                            @if($file && !$errors->has('file'))
                                            <div class="mt-3 flex items-center justify-between gap-2 text-sm font-bold text-gray-700 bg-gray-50 p-3 rounded-xl border border-gray-200 shadow-sm animate-fade-in">
                                                <div class="flex items-center gap-3 overflow-hidden">
                                                    <div class="p-2 bg-white rounded-lg shadow-sm border border-gray-100 shrink-0">
                                                        <x-heroicon-s-document-text class="w-5 h-5 text-[#e26a35]" />
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="truncate text-gray-900 leading-tight">{{ $file->getClientOriginalName() }}</p>
                                                        <p class="text-[10px] text-gray-500 uppercase tracking-wider mt-0.5">{{ number_format($file->getSize() / 1024, 2) }} KB</p>
                                                    </div>
                                                </div>
                                                <button type="button" wire:click="$set('file', null)" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0" title="Remove file">
                                                    <x-heroicon-o-x-mark class="w-5 h-5" />
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="pt-4 mt-auto">
                                        <button type="submit" wire:loading.attr="disabled" :disabled="uploading" {{ !$file ? 'disabled' : '' }} class="w-full flex justify-center items-center px-4 py-3.5 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] transition-all duration-200 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span wire:loading.remove wire:target="save">Upload and Parse</span>
                                            <span wire:loading.flex wire:target="save" class="items-center gap-2">
                                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Processing PDF...
                                            </span>
                                        </button>
                                        <button type="button" @click="showUpload = false" class="mt-3 w-full px-4 py-3.5 bg-white text-gray-700 border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-delete-modal show="showDeleteModal" title="Delete Resume"
        description="Are you sure you want to remove this resume? It will be permanently deleted from our servers and Cloudinary. This action cannot be undone."
        on-confirm="executeDelete" />
</div>