<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grit | Your Job Hunt, Automated</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased selection:bg-[#e26a35] selection:text-white relative font-sans">

    <x-header />

    <main class="relative min-h-[100svh] flex flex-col items-center justify-start bg-[#FBF6F1] pt-32 sm:pt-40 pb-16 px-4 sm:px-6 overflow-hidden font-sans">
        
        <style>
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-up {
                animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
            }
            .delay-200 { animation-delay: 200ms; }
        </style>

        <div class="text-center z-10 w-full max-w-5xl mx-auto animate-fade-up">
            <h1 class="text-[14vw] sm:text-7xl md:text-8xl lg:text-[9rem] font-extrabold tracking-tight leading-[0.9] text-gray-900 mb-6 sm:mb-8">
                THE GRIND,<br>
                <span class="text-[#e26a35]">AUTOMATED.</span>
            </h1>
            
            <p class="mt-4 sm:mt-6 text-lg sm:text-xl md:text-2xl text-gray-700 max-w-2xl mx-auto font-medium leading-relaxed px-2">
                Stop guessing and start landing offers. We use AI to track your applications, parse your resume, and prepare you for interviews.
            </p>

            <div class="mt-8 sm:mt-12 flex flex-col sm:flex-row gap-4 justify-center px-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-4 bg-[#e26a35] text-white font-bold rounded-full hover:bg-[#c95d2e] transition-transform hover:scale-105 shadow-lg shadow-[#e26a35]/40 text-lg">
                    Start Your Grind
                </a>
            </div>
        </div>

        <div class="relative mt-12 sm:mt-16 w-full max-w-4xl flex justify-center animate-fade-up delay-200 px-4">
            <img src="{{ asset('images/landing/hero-bursting-folder.webp') }}" 
                 alt="A rough ink sketch illustration of an orange folder bursting open with paper planes" 
                 class="w-full max-w-md sm:max-w-xl md:max-w-2xl object-contain mix-blend-multiply opacity-90 pointer-events-none">
        </div>

    </main>

</body>
</html>