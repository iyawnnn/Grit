<header class="fixed top-4 sm:top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-4xl font-sans transition-all duration-300">
    <div class="flex items-center justify-between px-4 sm:px-6 py-2.5 sm:py-3 bg-white/80 backdrop-blur-md border border-gray-100 shadow-sm rounded-full">

        <a href="/" class="flex-shrink-0 flex items-center group">
            <img src="{{ asset('images/grit-logo.svg') }}"
                alt="Grit AI Job Hunt and Career Tracking Platform Logo"
                class="h-7 sm:h-8 w-auto object-contain transition-transform duration-300 ease-in-out origin-center group-hover:rotate-90" />
        </a>

        <nav class="flex items-center gap-3 sm:gap-4">
            @auth
            <a href="{{ route('dashboard') }}" class="px-5 py-2 sm:px-6 text-sm font-semibold text-white bg-brand-orange rounded-full hover:opacity-90 transition-opacity shadow-sm">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-brand-orange transition-colors">
                Log In
            </a>

            <a href="{{ route('register') }}" class="px-4 py-2 sm:px-6 text-sm font-semibold text-white bg-brand-orange rounded-full hover:opacity-90 transition-opacity shadow-sm whitespace-nowrap">
                Start Your Grind
            </a>
            @endauth
        </nav>

    </div>
</header>