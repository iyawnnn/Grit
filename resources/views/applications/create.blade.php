<x-app-layout>
    <div class="max-w-3xl mx-auto flex flex-col h-full gap-6">

        <div class="flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('applications.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-900 bg-white border border-gray-200 rounded-md transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Track New Job</h1>
                    <p class="text-sm text-gray-500 mt-1">Save a job posting to your applications list.</p>
                </div>
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
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-semibold text-gray-900 mb-1.5">Company
                            Name</label>
                        <input type="text" name="company" id="company" required placeholder="e.g. Acme Corp"
                            class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                    </div>
                </div>

                <div>
                    <label for="url" class="block text-sm font-semibold text-gray-900 mb-1.5">Job URL <span
                            class="text-gray-400 font-normal">(Optional)</span></label>
                    <input type="url" name="url" id="url" placeholder="https://..."
                        class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-1.5">Job
                        Description</label>
                    <textarea name="description" id="description" rows="8" required
                        placeholder="Paste the full job description here..."
                        class="w-full rounded-md border-gray-200 bg-gray-50 focus:bg-white focus:border-[#e26a35] focus:ring-1 focus:ring-[#e26a35] text-sm transition-colors custom-scrollbar"></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#e26a35] text-white rounded-md text-sm font-medium hover:bg-[#cf5b29] transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Save Job Posting
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>