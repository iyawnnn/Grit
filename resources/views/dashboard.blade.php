<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-black">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Overview of your application tracker data.</p>
            </div>
            
            <button class="inline-flex items-center justify-center bg-brand-orange text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-[#e26a35] transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-brand-orange">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Application
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Total Applications</h3>
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <p class="text-3xl font-semibold text-black tracking-tight">0</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Saved Resumes</h3>
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <p class="text-3xl font-semibold text-black tracking-tight">0</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Average Match</h3>
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <p class="text-3xl font-semibold text-black tracking-tight">0%</p>
                    <span class="text-xs font-medium text-gray-500">Pending</span>
                </div>
            </div>

        </div>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mt-6">
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
                <h3 class="text-sm font-semibold text-black">Recent Activity</h3>
            </div>
            
            <div class="p-8 text-center flex flex-col items-center justify-center min-h-[200px]">
                <h3 class="text-sm font-medium text-black">No activity recorded</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm">You haven't uploaded any resumes or saved any job postings yet.</p>
                
                <button class="mt-4 text-sm font-medium text-brand-orange hover:text-[#e26a35] transition-colors">
                    Upload your first resume &rarr;
                </button>
            </div>
        </div>

    </div>
</x-app-layout>