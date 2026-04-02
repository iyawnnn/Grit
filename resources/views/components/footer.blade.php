<footer class="relative z-10 bg-[#e26a35] pt-24 sm:pt-32 pb-8 font-sans overflow-hidden">
    
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none z-0 overflow-hidden">
        <h1 class="text-[35vw] font-black text-white opacity-[0.04] whitespace-nowrap tracking-tighter mix-blend-overlay uppercase">
            GRIT
        </h1>
    </div>

    <div class="absolute inset-0 z-0 opacity-[0.04] bg-[url('{{ asset('images/landing/rough-ink-dots.png') }}')] mix-blend-multiply pointer-events-none"></div>

    <div class="relative z-10 max-w-5xl mx-auto text-center flex flex-col items-center px-4 sm:px-6">
        
        <h2 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black text-white tracking-tight leading-[1.05] mb-12 max-w-4xl drop-shadow-sm mt-8">
            Ready to stop guessing and start landing offers?
        </h2>
        
        <a href="{{ route('register') }}" class="group relative inline-flex justify-center items-center px-12 py-6 bg-white text-[#e26a35] font-extrabold rounded-full hover:bg-gray-50 transition-all duration-300 hover:scale-105 shadow-[0_0_40px_rgba(255,255,255,0.2)] hover:shadow-[0_0_60px_rgba(255,255,255,0.4)] text-xl sm:text-2xl z-20 border-2 border-transparent">
            Start Your Grind.
            <svg class="ml-3 w-6 h-6 transform transition-transform duration-300 group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>

    <div class="relative z-10 mt-24 sm:mt-32 w-full overflow-hidden border-y border-white/10 bg-white/5 py-4">
        <style>
            @keyframes scroll-ticker {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .animate-ticker {
                animation: scroll-ticker 20s linear infinite;
            }
        </style>
        
        <div class="animate-ticker flex w-max text-white/60 font-bold tracking-widest uppercase text-xs sm:text-sm">
            
            <div class="flex items-center">
                <span class="px-6">AUTOMATE YOUR HUNT</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">BEAT THE ATS</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">CRUSH THE INTERVIEW</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">LAND THE OFFER</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">AUTOMATE YOUR HUNT</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">BEAT THE ATS</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">CRUSH THE INTERVIEW</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">LAND THE OFFER</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
            </div>

            <div class="flex items-center">
                <span class="px-6">AUTOMATE YOUR HUNT</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">BEAT THE ATS</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">CRUSH THE INTERVIEW</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">LAND THE OFFER</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">AUTOMATE YOUR HUNT</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">BEAT THE ATS</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">CRUSH THE INTERVIEW</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                <span class="px-6">LAND THE OFFER</span> <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
            </div>
            
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto pt-6 px-4 sm:px-6 flex flex-col md:flex-row items-center justify-between text-white/70 text-xs sm:text-sm font-medium">
        <p>&copy; {{ date('Y') }} Grit. All rights reserved.</p>
        <div class="flex gap-4 sm:gap-6 mt-4 md:mt-0 items-center flex-wrap justify-center">
            <a href="#" class="hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white rounded-sm">Privacy Policy</a>
            <span class="text-white/20 hidden sm:inline">|</span>
            <a href="#" class="hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white rounded-sm">Terms of Service</a>
            <span class="text-white/20 hidden sm:inline">|</span>
            <a href="#" class="hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white rounded-sm">Contact Support</a>
        </div>
    </div>
    
</footer>