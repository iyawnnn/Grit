<x-app-layout>
    <x-slot:title>Workspace Dashboard</x-slot:title>

    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 lg:py-10 flex flex-col gap-8 tracking-tight">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-[#fff5f0] rounded-xl shadow-sm border border-[#e26a35]/20 text-[#e26a35]">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Workspace Overview</h1>
                    <p class="text-sm text-gray-500 font-medium mt-1">Track your application performance and profile readiness.</p>
                </div>
            </div>
            
            <a href="{{ route('matches.index', ['action' => 'create']) }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-[#e26a35] text-white rounded-xl text-sm font-semibold hover:bg-[#c95a2b] transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e26a35] focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Analyze Job Match
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 shrink-0">
            
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md hover:border-[#e26a35]/40 transition-all group relative overflow-hidden flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20 text-[#e26a35]">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Active Resumes</span>
                    </div>
                    <a href="{{ route('resumes.index') }}" class="text-[#e26a35] opacity-0 group-hover:opacity-100 transition-opacity" aria-label="View Resumes">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black text-gray-900 tracking-tighter">{{ $totalResumes }}</span>
                    <span class="text-sm font-medium text-gray-400">Total</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md hover:border-[#e26a35]/40 transition-all group relative overflow-hidden flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20 text-[#e26a35]">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Analyzed Jobs</span>
                    </div>
                    <a href="{{ route('matches.index') }}" class="text-[#e26a35] opacity-0 group-hover:opacity-100 transition-opacity" aria-label="View Analyzed Jobs">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black text-gray-900 tracking-tighter">{{ $totalReports }}</span>
                    <span class="text-sm font-medium text-gray-400">Reports</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-[#fff5f0] rounded-lg border border-[#e26a35]/20 text-[#e26a35]">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Average Match</span>
                    </div>
                    <div class="p-1 {{ $averageScore > 75 ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }} rounded-md">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 19.5 16.5h-2.25m-9 0h9l-3 3m-3-3-3 3" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black tracking-tighter {{ $averageScore > 75 ? 'text-green-600' : 'text-gray-900' }}">{{ $averageScore }}%</span>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col h-full">
                <div class="mb-6 shrink-0 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Match Score Trend</h2>
                        <p class="text-sm text-gray-500 font-medium mt-1">Your performance over recent applications.</p>
                    </div>
                </div>
                
                @if(count($chartData) > 1)
                    <div class="relative w-full flex-1 min-h-[300px]"
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
                    <div class="flex-1 flex flex-col items-center justify-center bg-gray-50/50 rounded-xl border border-dashed border-gray-300 p-8 text-center h-full min-h-[300px]">
                        <div class="p-3 bg-[#fff5f0] rounded-full shadow-sm mb-4 border border-[#e26a35]/20 text-[#e26a35]">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1">More data needed</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-5 leading-relaxed">Analyze at least two job descriptions to unlock your performance chart.</p>
                        <a href="{{ route('matches.index', ['action' => 'create']) }}" class="px-5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-900 hover:border-[#e26a35] hover:text-[#e26a35] transition-all shadow-sm">Analyze a Job</a>
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-6 h-full">
                
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm shrink-0">
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

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col flex-1">
                    <div class="px-6 py-5 border-b border-gray-100 bg-white shrink-0">
                        <h2 class="text-base font-bold text-gray-900">Recent Analyses</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100 overflow-y-auto flex-1">
                        @forelse($recentReports as $report)
                            <a href="{{ route('matches.show', $report) }}" class="flex items-center justify-between p-5 hover:bg-gray-50 transition-colors group">
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
                            <div class="p-8 text-center bg-white h-full flex flex-col items-center justify-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#fff5f0] border border-[#e26a35]/20 text-[#e26a35] mb-3">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900 mb-1">Your feed is quiet</p>
                                <p class="text-xs text-gray-500 font-medium mb-4">You have not analyzed any jobs yet.</p>
                                <a href="{{ route('matches.index', ['action' => 'create']) }}" class="text-xs font-bold text-[#e26a35] hover:text-[#c95a2b] transition-colors uppercase tracking-widest">Find a match &rarr;</a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>