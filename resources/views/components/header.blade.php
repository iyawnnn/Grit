<header class="fixed top-4 sm:top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-3xl font-sans transition-all duration-300">
    <div class="flex items-center justify-between pl-6 pr-2 py-2 bg-white/75 backdrop-blur-2xl border border-white/80 shadow-[0_8px_32px_rgba(226,106,53,0.08)] rounded-full">
        
        <a href="/" class="flex-shrink-0 flex items-center group">
            <img src="{{ asset('images/grit-logo.svg') }}" 
                 alt="Grit Career Tracking Platform Logo" 
                 class="h-7 sm:h-8 w-auto max-w-[120px] object-contain transition-all duration-500 drop-shadow-sm group-hover:scale-110 group-hover:drop-shadow-[0_0_15px_rgba(226,106,53,0.6)]" />
        </a>

        <div class="flex items-center gap-1 sm:gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-[#e26a35] rounded-full hover:bg-[#c95d2e] transition-all shadow-md hover:-translate-y-0.5 hover:shadow-lg">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="hidden sm:inline-flex px-5 py-2.5 text-sm font-bold text-gray-700 hover:text-[#e26a35] transition-colors rounded-full hover:bg-gray-100/50">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-[#e26a35] rounded-full hover:bg-[#c95d2e] transition-all shadow-md hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#e26a35]/30">
                    Start Your Grind
                </a>
            @endauth
        </div>

    </div>
</header>