<div class="flex justify-center w-full py-4" wire:poll.3s>
    @php
        $score = $getRecord()->score;
        $isPending = $score === 0;
        
        // Define colors based on the score
        $textColor = match(true) {
            $score >= 80 => 'text-green-500',
            $score >= 50 => 'text-yellow-500',
            $score > 0 => 'text-red-500',
            default => 'text-gray-400',
        };
        
        $strokeColor = match(true) {
            $score >= 80 => 'stroke-green-500',
            $score >= 50 => 'stroke-yellow-500',
            $score > 0 => 'stroke-red-500',
            default => 'stroke-gray-300',
        };

        // Math for the SVG circle animation
        $radius = 60;
        $circumference = 2 * pi() * $radius;
        $dashOffset = $circumference - ($score / 100) * $circumference;
    @endphp

    <div class="flex flex-col items-center justify-center space-y-4">
        <div class="relative inline-flex items-center justify-center">
            <svg class="w-40 h-40 transform -rotate-90" aria-label="Circular Match Score">
                <circle cx="80" cy="80" r="{{ $radius }}" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-100" />
                
                <circle cx="80" cy="80" r="{{ $radius }}" stroke="currentColor" stroke-width="12" fill="transparent"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $dashOffset }}"
                        class="{{ $strokeColor }} transition-all duration-1000 ease-out" />
            </svg>
            <div class="absolute flex flex-col items-center justify-center">
                <span class="text-4xl font-bold {{ $textColor }}">
                    {{ $isPending ? '...' : $score . '%' }}
                </span>
            </div>
        </div>
        
        <span class="text-lg font-medium text-gray-500">
            {{ $isPending ? 'AI is analyzing...' : 'Overall Match Score' }}
        </span>
    </div>
</div>