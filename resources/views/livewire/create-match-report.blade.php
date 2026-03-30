<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <form wire:submit="generate" class="p-6 sm:p-8 space-y-6">
        
        <div>
            <label for="job_posting_id" class="block text-sm font-semibold text-gray-900 mb-1.5">Select a Saved Job</label>
            <select wire:model="job_posting_id" id="job_posting_id" required
                class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm">
                <option value="" disabled>Choose a job...</option>
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}">{{ $job->title }} at {{ $job->company }}</option>
                @endforeach
            </select>
            @error('job_posting_id') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="resume_id" class="block text-sm font-semibold text-gray-900 mb-1.5">Select a Resume</label>
            <select wire:model="resume_id" id="resume_id" required
                class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm">
                <option value="" disabled>Choose a resume...</option>
                @foreach($resumes as $resume)
                    <option value="{{ $resume->id }}">{{ $resume->label }}</option>
                @endforeach
            </select>
            @error('resume_id') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" wire:loading.attr="disabled"
                class="px-5 py-2.5 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">

                <span wire:loading.remove wire:target="generate">Generate Match Report</span>

                <span wire:loading.flex wire:target="generate" class="items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Analyzing Match...
                </span>
            </button>
        </div>
    </form>
</div>