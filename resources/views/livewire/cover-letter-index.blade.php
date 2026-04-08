<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 relative" x-data="{ showDeleteModal: false }">

    <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 mb-10">
        <div class="flex flex-col items-center md:items-start w-full md:w-auto">
            <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20">
                    <x-heroicon-o-envelope class="w-6 h-6 text-[#e26a35]" />
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Cover Letters</h1>
            </div>
            <p class="text-base font-medium text-gray-500 max-w-sm mx-auto md:mx-0">
                Manage and edit tailored cover letters for your applications.
            </p>
        </div>
        
        <div class="flex gap-3 w-full md:w-auto">
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-cover-letter-modal')"
                class="w-full md:w-auto justify-center px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
                <x-heroicon-o-document-plus class="w-5 h-5" />
                Generate New Letter
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-[#fff5f0] rounded-xl">
                <x-heroicon-o-envelope-open class="w-6 h-6 text-[#e26a35]" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Active Drafts</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalDrafts }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-gray-50 rounded-xl">
                <x-heroicon-o-briefcase class="w-6 h-6 text-gray-600" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Available Jobs</p>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ count($availableJobs) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors flex items-center gap-4">
            <div class="p-3 bg-indigo-50 rounded-xl">
                <x-heroicon-o-bolt class="w-6 h-6 text-indigo-600" />
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Daily AI Credits</p>
                <div class="flex items-baseline gap-1">
                    <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $creditsRemaining }}</p>
                    <p class="text-sm font-semibold text-gray-400">/ {{ $dailyLimit }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-8 z-30 relative">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search saved letters by role or company..."
                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white text-sm font-medium focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] transition-all shadow-sm outline-none text-gray-900 placeholder-gray-400">
        </div>
    </div>

    <div class="relative min-h-[400px] z-10">
        <div wire:loading.grid wire:target="search, gotoPage"
            class="absolute inset-0 z-10 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 bg-[#f9fafb]">
            @for ($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col h-full animate-pulse">
                    <div class="h-7 w-24 bg-gray-200 rounded-full mb-6"></div>
                    <div class="mb-8 flex-1">
                        <div class="h-6 w-3/4 bg-gray-200 rounded-md mb-4"></div>
                        <div class="h-4 w-1/2 bg-gray-100 rounded-md"></div>
                    </div>
                </div>
            @endfor
        </div>

        <div wire:loading.remove wire:target="search, gotoPage">
            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                        <div wire:key="job-card-{{ $job->id }}"
                            class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#e26a35]/40 hover:-translate-y-1 transition-all duration-300 flex flex-col p-6 group h-full">

                            <div class="flex justify-between items-start mb-6 shrink-0">
                                <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-green-50 text-green-700 border border-green-200">
                                    Draft Saved
                                </div>
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-400 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                                    <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                                    {{ $job->updated_at->format('M d') }}
                                </div>
                            </div>

                            <div class="mb-6 flex-1">
                                <h3 class="text-xl font-extrabold text-gray-900 leading-tight mb-2 group-hover:text-[#e26a35] transition-colors">
                                    {{ $job->title }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm font-semibold text-gray-500">
                                    <x-heroicon-o-building-office-2 class="w-4 h-4 opacity-70" />
                                    {{ $job->company }}
                                </div>
                            </div>

                            <div class="pt-5 border-t border-gray-100 flex items-center justify-between mt-auto shrink-0">
                                <a href="{{ route('cover-letters.edit', $job) }}"
                                    class="text-sm font-bold text-gray-600 hover:text-[#e26a35] transition-colors flex items-center gap-1.5 group/link">
                                    Open Workspace
                                    <x-heroicon-o-arrow-up-right
                                        class="w-4 h-4 opacity-0 -translate-y-1 translate-x-1 group-hover/link:opacity-100 group-hover/link:translate-y-0 group-hover/link:translate-x-0 transition-all duration-300" />
                                </a>

                                <button type="button" @click="$wire.confirmDelete({{ $job->id }}); showDeleteModal = true"
                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($jobs->hasPages())
                    <div class="mt-10 custom-pagination">
                        {{ $jobs->links() }}
                    </div>
                @endif
            @else
                <div class="w-full bg-white rounded-3xl border border-gray-200 flex flex-col items-center justify-center text-center p-16 sm:p-24 shadow-sm">
                    <div class="w-20 h-20 bg-[#fff5f0] rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-[#e26a35]/10">
                        <x-heroicon-o-envelope class="w-10 h-10 text-[#e26a35]" />
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">No Cover Letters Yet</h3>
                    <p class="text-base font-medium text-gray-500 max-w-md mx-auto mb-8">
                        You have not generated any cover letters yet. Click the button above to select a job application and start drafting.
                    </p>
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-cover-letter-modal')"
                        class="px-6 py-3 bg-[#e26a35] text-white rounded-xl text-sm font-bold tracking-tight hover:bg-[#cf5b29] hover:shadow-lg transition-all duration-200 inline-flex items-center gap-2">
                        <x-heroicon-o-document-plus class="w-5 h-5" />
                        Generate New Letter
                    </button>
                </div>
            @endif
        </div>
    </div>

    <x-modal name="create-cover-letter-modal" maxWidth="md">
        <div class="relative overflow-hidden bg-white rounded-2xl">
            <div class="bg-gradient-to-b from-[#fff5f0] to-white px-6 py-8 border-b border-gray-100 text-center">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm border border-[#e26a35]/20">
                    <x-heroicon-o-document-plus class="w-8 h-8 text-[#e26a35]" />
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-2">New Cover Letter</h2>
                <p class="text-sm font-medium text-gray-500 max-w-xs mx-auto">Select a target application to generate a tailored letter using your primary resume.</p>
            </div>
            
            <div class="p-6">
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Target Application</label>
                    
                    <div x-data="{ open: false, selectedId: @entangle('selectedJobForNewLetter') }" class="relative">
                        <button type="button" @click="open = !open" @click.outside="open = false"
                            class="w-full flex justify-between items-center rounded-xl border border-gray-300 py-3 pl-4 pr-4 text-gray-900 font-medium focus:outline-none focus:border-[#e26a35] focus:ring-2 focus:ring-[#e26a35]/20 shadow-sm bg-gray-50 hover:bg-white transition-all cursor-pointer text-left h-[50px]">
                            
                            <span x-show="!selectedId" class="text-gray-500 truncate pr-4">-- Choose an application --</span>
                            
                            @foreach($availableJobs as $job)
                                <span x-show="selectedId == {{ $job->id }}" x-cloak class="truncate pr-4">
                                    {{ $job->title }} <span class="text-gray-500 font-normal">at {{ $job->company }}</span>
                                </span>
                            @endforeach

                            <x-heroicon-o-chevron-down class="w-5 h-5 text-gray-500 shrink-0 transition-transform duration-200" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>

                        <div x-show="open" x-cloak x-transition.opacity
                            class="absolute z-50 mt-2 w-full rounded-xl bg-white shadow-xl border border-gray-100 overflow-hidden py-2 max-h-60 overflow-y-auto custom-scrollbar">
                            
                            <button type="button" @click="selectedId = ''; open = false"
                                class="w-full text-left px-5 py-2.5 text-sm font-medium hover:bg-gray-50 transition-colors"
                                :class="selectedId == '' ? 'bg-gray-50 text-gray-900' : 'text-gray-500'">
                                -- Choose an application --
                            </button>
                            
                            @foreach($availableJobs as $availableJob)
                                <button type="button" @click="selectedId = {{ $availableJob->id }}; open = false"
                                    class="w-full text-left px-5 py-2.5 text-sm font-semibold transition-colors truncate"
                                    :class="selectedId == {{ $availableJob->id }} ? 'bg-[#fff5f0] text-[#e26a35]' : 'text-gray-700 hover:bg-[#fff5f0] hover:text-[#e26a35]'">
                                    {{ $availableJob->title }} <span class="text-gray-400 font-normal">at {{ $availableJob->company }}</span>
                                </button>
                            @endforeach
                            
                            @if(count($availableJobs) === 0)
                                <div class="px-5 py-3 text-sm text-gray-500 italic">No applications available.</div>
                            @endif
                        </div>
                    </div>
                    
                    @error('selectedJobForNewLetter') <span class="text-red-500 text-sm font-medium mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-3">
                    <button wire:click="startWorkspace" 
                        class="w-full flex justify-center items-center gap-2 px-4 py-3.5 text-sm font-bold text-white bg-[#e26a35] rounded-xl hover:bg-[#cf5b29] disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm" 
                        @if(empty($selectedJobForNewLetter)) disabled @endif>
                        Continue to Editor
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </button>
                    <button type="button" x-on:click="$dispatch('close-modal', 'create-cover-letter-modal')" 
                        class="w-full px-4 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </x-modal>

    <x-delete-modal show="showDeleteModal" title="Delete Cover Letter"
        description="Are you sure you want to remove this cover letter? This will not delete the job application, only the drafted text. This action cannot be undone."
        on-confirm="executeDelete" on-cancel="cancelDelete" />
</div>