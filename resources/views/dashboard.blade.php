<x-app-layout>
    <div class="max-w-7xl mx-auto">

        <div class="mb-8">
            <h2 class="text-3xl font-bold tracking-tight text-black">Dashboard Overview</h2>
            <p class="text-sm text-gray-500 mt-1">Track your progress and co-pilot your career journey.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Applications</h3>
                    <p class="text-5xl font-bold text-black mt-4">24</p>
                </div>
                <div class="mt-6 flex items-center gap-2 text-sm">
                    <span class="text-[#e26a35] font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +3
                    </span>
                    <span class="text-gray-400">this week</span>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm flex flex-col items-center justify-center relative">
                <h3
                    class="text-sm font-semibold text-gray-500 uppercase tracking-wider w-full text-left absolute top-6 left-6">
                    Match Score</h3>

                <div class="relative w-32 h-32 mt-4">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-gray-100" stroke-width="3" stroke="currentColor" fill="none"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="text-[#e26a35]" stroke-dasharray="85, 100" stroke-width="3" stroke-linecap="round"
                            stroke="currentColor" fill="none"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-bold text-black">85</span>
                        <span class="text-xs text-gray-400">%</span>
                    </div>
                </div>
                <p class="text-sm text-gray-400 mt-4 text-center">Your profile matches 85% of target job descriptions.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2 text-black">Ready for a new application?</h3>
                    <p class="text-gray-500 text-sm">Upload your latest resume to get instant match scores.</p>
                </div>
                <button
                    class="w-full py-3 px-4 bg-[#e26a35] text-white rounded-2xl font-semibold text-sm shadow-sm hover:bg-[#cf5b29] transition-colors">
                    Upload Resume
                </button>
            </div>

            <div class="md:col-span-2 bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-black">Recent Activity</h3>
                    <a href="#" class="text-sm font-medium text-[#e26a35] hover:underline">View all</a>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-xl">
                                🚀
                            </div>
                            <div>
                                <p class="text-sm font-bold text-black">Applied to Senior Developer</p>
                                <p class="text-xs text-gray-500">at TechCorp Inc.</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">2 hours ago</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-xl">
                                💻
                            </div>
                            <div>
                                <p class="text-sm font-bold text-black">Interview Scheduled</p>
                                <p class="text-xs text-gray-500">with StartupHub</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">Yesterday</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Profile Completion</h3>
                    <p class="text-5xl font-bold text-black mt-4">92%</p>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5 mt-6">
                    <div class="bg-[#e26a35] h-2.5 rounded-full" style="width: 92%"></div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>