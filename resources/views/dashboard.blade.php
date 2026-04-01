<x-app-layout>
    <x-slot:title>Workspace Dashboard</x-slot:title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="w-full flex flex-col gap-6 lg:gap-8 tracking-tight">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Workspace Overview</h1>
                <p class="text-sm text-gray-500 font-medium mt-1">Track your application performance and profile readiness.</p>
            </div>
            <a href="{{ route('matches.create') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-[#e26a35] text-white rounded-xl text-sm font-semibold hover:bg-[#c95a2b] transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e26a35] focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Analyze Job Match
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 shrink-0">
            
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors group relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Active Resumes</span>
                    <a href="{{ route('resumes.index') }}" class="text-[#e26a35] opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg>
                    </a>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black text-gray-900 tracking-tighter">{{ $totalResumes }}</span>
                    <span class="text-sm font-medium text-gray-400">Total</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-[#e26a35]/40 transition-colors group relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Analyzed Jobs</span>
                    <a href="{{ route('matches.index') }}" class="text-[#e26a35] opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg>
                    </a>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black text-gray-900 tracking-tighter">{{ $totalReports }}</span>
                    <span class="text-sm font-medium text-gray-400">Reports</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex justify-between items-start">
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Average Match</span>
                    <div class="p-1 {{ $averageScore > 75 ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }} rounded-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black tracking-tighter {{ $averageScore > 75 ? 'text-green-600' : 'text-gray-900' }}">{{ $averageScore }}%</span>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col min-h-[400px]">
                <div class="mb-6 shrink-0">
                    <h2 class="text-lg font-bold text-gray-900">Match Score Trend</h2>
                    <p class="text-sm text-gray-500 font-medium mt-1">Your performance over recent applications.</p>
                </div>
                
                @if(count($chartData) > 1)
                    <div class="relative w-full flex-1"
                         x-data="{
                             init() {
                                 const ctx = this.$refs.canvas.getContext('2d');
                                 const gradient = ctx.createLinearGradient(0, 0, 0, 320);
                                 gradient.addColorStop(0, 'rgba(226, 106, 53, 0.2)');
                                 gradient.addColorStop(1, 'rgba(226, 106, 53, 0)');
                                 
                                 new Chart(ctx, {
                                     type: 'line',
                                     data: {
                                         labels: @js($chartLabels),
                                         datasets: [{
                                             data: @js($chartData),
                                             borderColor: '#e26a35',
                                             backgroundColor: gradient,
                                             borderWidth: 3,
                                             pointBackgroundColor: '#ffffff',
                                             pointBorderColor: '#e26a35',
                                             pointBorderWidth: 2,
                                             pointRadius: 4,
                                             pointHoverRadius: 6,
                                             fill: true,
                                             tension: 0.4
                                         }]
                                     },
                                     options: {
                                         responsive: true,
                                         maintainAspectRatio: false,
                                         plugins: {
                                             legend: { display: false },
                                             tooltip: {
                                                 backgroundColor: '#111827',
                                                 padding: 12,
                                                 cornerRadius: 8,
                                                 titleFont: { family: 'Instrument Sans', size: 13 },
                                                 bodyFont: { family: 'Instrument Sans', size: 14, weight: 'bold' },
                                                 displayColors: false,
                                                 callbacks: {
                                                     title: function(context) { return @js($chartTooltips)[context[0].dataIndex]; },
                                                     label: function(context) { return context.parsed.y + '% Match Score'; }
                                                 }
                                             }
                                         },
                                         scales: {
                                             y: {
                                                 beginAtZero: true, max: 100,
                                                 grid: { color: '#f3f4f6', borderDash: [5, 5] },
                                                 ticks: { font: { family: 'Instrument Sans' }, color: '#9ca3af' }
                                             },
                                             x: {
                                                 grid: { display: false },
                                                 ticks: { font: { family: 'Instrument Sans' }, color: '#9ca3af' }
                                             }
                                         }
                                     }
                                 });
                             }
                         }">
                        <canvas x-ref="canvas"></canvas>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center bg-gray-50/50 rounded-xl border border-dashed border-gray-300 p-8 text-center">
                        <div class="p-3 bg-white rounded-full shadow-sm mb-4 border border-gray-100">
                            <svg class="w-6 h-6 text-[#e26a35]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1">More data needed</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-5 leading-relaxed">Analyze at least two job descriptions to unlock your performance chart.</p>
                        <a href="{{ route('matches.create') }}" class="px-5 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-900 hover:border-[#e26a35] hover:text-[#e26a35] transition-all shadow-sm">Analyze a Job</a>
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-6">
                
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Overall Readiness</h2>
                    
                    <div class="flex items-baseline gap-1 mb-3">
                        <span class="text-4xl font-black text-gray-900 tracking-tighter">{{ $readiness }}</span>
                        <span class="text-xl font-bold text-gray-400">%</span>
                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-2.5 mb-5 overflow-hidden">
                        <div class="bg-[#e26a35] h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ $readiness }}%"></div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-sm font-bold text-gray-900 mb-1">{{ $readinessMessage }}</p>
                        <p class="text-xs text-gray-600 font-medium leading-relaxed">{{ $readinessSubtext }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-base font-bold text-gray-900">Recent Analyses</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($recentReports as $report)
                            <a href="{{ route('matches.show', $report) }}" class="flex items-center justify-between p-5 hover:bg-[#e26a35]/5 transition-colors group">
                                <div class="truncate pr-4">
                                    <h3 class="text-sm font-bold text-gray-900 truncate group-hover:text-[#e26a35] transition-colors">{{ $report->jobPosting->title ?? 'Deleted Job' }}</h3>
                                    <p class="text-xs text-gray-500 font-medium mt-1 truncate">{{ $report->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="shrink-0">
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold border {{ $report->score > 75 ? 'bg-green-50 text-green-700 border-green-200' : 'bg-white text-gray-700 border-gray-200 shadow-sm' }}">
                                        {{ $report->score }}%
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center bg-white">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#e26a35]/10 text-[#e26a35] mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900 mb-1">Your feed is quiet</p>
                                <p class="text-xs text-gray-500 font-medium mb-4">You have not analyzed any jobs yet.</p>
                                <a href="{{ route('matches.create') }}" class="text-xs font-bold text-[#e26a35] hover:text-[#c95a2b] transition-colors uppercase tracking-widest">Find a match &rarr;</a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>