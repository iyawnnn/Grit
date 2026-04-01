<div class="mx-auto max-w-4xl p-6 font-['Instrument_Sans'] tracking-tight">
    <div class="rounded-xl border border-gray-100 bg-white p-8 shadow-sm">
        <h2 class="mb-2 text-2xl font-bold text-gray-900">Interview Preparation</h2>
        <p class="mb-8 text-gray-600">Generate customized interview questions based on your resume and this job posting.</p>

        @if(empty($questions))
            <div class="flex justify-center py-12">
                <button 
                    wire:click="generateQuestions" 
                    wire:loading.attr="disabled"
                    class="flex items-center gap-2 rounded-lg bg-[#e26a35] px-6 py-3 font-medium text-white transition-colors hover:bg-[#c95b2b] disabled:opacity-50"
                >
                    <span wire:loading.remove>Generate Mock Interview</span>
                    <span wire:loading>Generating...</span>
                </button>
            </div>
        @else
            <div class="space-y-6">
                @foreach($questions as $index => $question)
                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                        <h3 class="mb-2 font-semibold text-gray-900">Question {{ $index + 1 }}</h3>
                        <p class="text-gray-800">{{ $question }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @error('api')
            <div class="mt-4 rounded-lg bg-red-50 p-4 text-sm text-red-600">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>