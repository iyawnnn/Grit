<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
    <div class="p-6 sm:p-8 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-[#fff5f0] rounded-xl border border-[#e26a35]/20 text-[#e26a35]">
                <x-heroicon-o-map class="w-6 h-6" />
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Grit Action Plan</h2>
                <p class="text-sm font-medium text-gray-500">Your personalized roadmap to bridge skill gaps.</p>
            </div>
        </div>
    </div>

    <div class="p-6 sm:p-8 min-h-[200px]">
        
        <div wire:loading wire:target="generatePlan" class="w-full py-8">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="relative w-16 h-16 mb-4">
                    <div class="absolute inset-0 border-4 border-[#fff5f0] rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-[#e26a35] rounded-full border-t-transparent animate-spin"></div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Mapping your route...</h3>
                <p class="text-sm font-medium text-gray-500">Our AI is drafting the best learning path for you.</p>
            </div>
        </div>

        <div wire:loading.remove wire:target="generatePlan">
            
            @if($matchReport->action_plan)
                @php
                    $planData = json_decode($matchReport->action_plan, true);
                    $steps = $planData['steps'] ?? [];
                @endphp

                @if(!empty($steps))
                    <div class="space-y-6">
                        @foreach($steps as $step)
                            <div>
                                <h3 class="text-lg font-extrabold text-gray-900 border-b border-gray-100 pb-2 mb-3">
                                    {{ $step['title'] }}
                                </h3>
                                
                                <ul class="list-disc pl-5 space-y-2 marker:text-[#e26a35] text-sm text-gray-600 font-medium leading-relaxed">
                                    @foreach($step['actions'] as $action)
                                        <li>{!! preg_replace('/\*\*(.*?)\*\*/', '<strong class="font-black text-gray-900 bg-gray-50 border border-gray-200 px-1.5 py-0.5 rounded-md shadow-sm">$1</strong>', $action) !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Failed to parse the action plan data. Please try again later.</p>
                @endif

            @elseif($errorMessage)
                <div class="text-center py-6">
                    <div class="mx-auto w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-3">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-500" />
                    </div>
                    <p class="text-red-500 font-medium mb-4">{{ $errorMessage }}</p>
                    <button wire:click="generatePlan" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition-colors shadow-sm">
                        Try Again
                    </button>
                </div>

            @else
                <div class="text-center py-4">
                    <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                        <x-heroicon-o-rocket-launch class="w-8 h-8 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Ready to level up?</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">
                        Generate a personalized, step-by-step action plan to master the skills you are missing for this role.
                    </p>
                    <button 
                        wire:click="generatePlan" 
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#e26a35] text-white text-sm font-bold rounded-xl hover:bg-[#d15823] transition-colors shadow-sm"
                    >
                        <x-heroicon-s-bolt class="w-4 h-4" />
                        Generate Action Plan
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>