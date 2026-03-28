<x-app-layout>
    <div class="max-w-4xl mx-auto flex flex-col h-full gap-6">

        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('applications.index') }}"
                class="p-2 text-gray-400 hover:text-gray-900 bg-white border border-gray-200 rounded-md transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Track New Application</h1>
                <p class="text-sm text-gray-500 mt-1">Enter the job details to generate an AI match report.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('applications.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-900 mb-1.5">Job Title</label>
                        <input type="text" name="title" id="title" required placeholder="e.g. Senior Frontend Engineer"
                            class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                        @error('title') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-semibold text-gray-900 mb-1.5">Company
                            Name</label>
                        <input type="text" name="company" id="company" required placeholder="e.g. Acme Corp"
                            class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                        @error('company') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="resume_id" class="block text-sm font-semibold text-gray-900 mb-1.5">Select Resume to
                            Match</label>
                        <select name="resume_id" id="resume_id" required
                            class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                            <option value="" disabled selected>Choose a resume...</option>
                            @foreach($resumes as $resume)
                                <option value="{{ $resume->id }}">{{ $resume->label }}</option>
                            @endforeach
                        </select>
                        @error('resume_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="url" class="block text-sm font-semibold text-gray-900 mb-1.5">Job URL <span
                                class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="url" name="url" id="url" placeholder="https://..."
                            class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                        @error('url') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-1.5">Job
                        Description</label>
                    <p class="text-xs text-gray-500 mb-2">Paste the full job description here. Our AI will analyze it
                        against your selected resume.</p>
                    <textarea name="description" id="description" rows="8" required
                        placeholder="Paste job description here..."
                        class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors custom-scrollbar"></textarea>
                    @error('description') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Match Report
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>