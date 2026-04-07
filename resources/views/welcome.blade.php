<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Grit | Your Job Hunt, Automated</title>
    <meta name="description" content="Upload your resume, track job applications, and generate AI mock interviews to land your next role faster.">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Grit | Your Job Hunt, Automated">
    <meta property="og:description" content="Upload your resume, track job applications, and generate AI mock interviews to land your next role faster.">
    <meta property="og:image" content="{{ asset('images/landing/grit-social-share.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Grit | Your Job Hunt, Automated">
    <meta name="twitter:description" content="Upload your resume, track job applications, and generate AI mock interviews to land your next role faster.">
    <meta name="twitter:image" content="{{ asset('images/landing/grit-social-share.jpg') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900 antialiased selection:bg-[#e26a35] selection:text-white relative font-sans">

    <x-header />

    <main>

        <section class="relative min-h-[100svh] flex flex-col items-center justify-start bg-[#FBF6F1] pt-32 sm:pt-40 pb-16 px-4 sm:px-6 overflow-hidden">

            <div class="absolute inset-0 z-0 bg-[linear-gradient(to_right,#e26a3515_1px,transparent_1px),linear-gradient(to_bottom,#e26a3515_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_80%_60%_at_50%_0%,#000_60%,transparent_100%)]"></div>

            <style nonce="{{ app()->bound('csp-nonce') ? app('csp-nonce') : '' }}">
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-fade-up {
                    animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                    opacity: 0;
                }

                .delay-200 {
                    animation-delay: 200ms;
                }
            </style>

            <div class="relative text-center z-10 w-full max-w-5xl mx-auto animate-fade-up">

                <div class="mb-6 flex justify-center w-full">
                    <span class="inline-block px-4 py-1.5 rounded-full border-2 border-gray-900 font-bold text-[10px] sm:text-xs tracking-wider uppercase text-gray-900 bg-white shadow-[4px_4px_0px_0px_rgba(17,24,39,1)] rotate-[-4deg] hover:rotate-0 transition-transform cursor-default">
                        Smarter Job Search
                    </span>
                </div>

                <h1 class="relative inline-block text-[14vw] sm:text-7xl md:text-8xl lg:text-[9rem] font-extrabold tracking-tight leading-[0.9] text-gray-900 mb-6 sm:mb-8 pt-4">
                    THE GRIND,<br>

                    <span class="text-[#e26a35] relative inline-block pr-[0.4em]">
                        AUTOMATED.

                        <svg class="absolute w-[0.55em] h-[0.55em] right-0 -top-[0.2em] text-[#e26a35] opacity-60 transform hover:scale-110 hover:-translate-y-2 hover:translate-x-2 transition-transform duration-300 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z" />
                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z" />
                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0" />
                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5" />
                        </svg>
                    </span>
                </h1>

                <p class="mt-4 sm:mt-6 text-lg sm:text-xl md:text-2xl text-gray-700 max-w-2xl mx-auto font-medium leading-relaxed px-2">
                    Stop guessing and start landing offers. We use AI to track your applications, parse your resume, and prepare you for interviews.
                </p>

                <div class="mt-8 sm:mt-12 flex justify-center px-4 w-full">

                    <div class="relative inline-flex items-center">

                        <div class="hidden md:block absolute right-[110%] top-1/2 -translate-y-1/2 opacity-40 pointer-events-none w-[70px]">
                            <svg viewBox="0 0 100 100" fill="none" class="text-gray-900 w-full h-auto">
                                <path d="M10 70 Q 40 20, 90 50" stroke="currentColor" stroke-width="4" stroke-linecap="round" fill="none" />
                                <path d="M70 35 L 90 50 L 70 65" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                        </div>

                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-4 bg-[#e26a35] text-white font-bold rounded-full hover:bg-[#c95d2e] transition-transform hover:scale-105 shadow-lg shadow-[#e26a35]/40 text-lg border-2 border-transparent hover:border-gray-900 relative z-10">
                            Start Your Grind
                        </a>
                    </div>
                </div>
            </div>

            <div class="relative mt-12 sm:mt-16 w-full max-w-4xl flex justify-center animate-fade-up delay-200 px-4 z-10">
                <img src="{{ asset('images/landing/hero-bursting-folder.webp') }}"
                    alt="A rough ink sketch illustration of an orange folder bursting open with paper planes"
                    class="w-full max-w-md sm:max-w-xl md:max-w-2xl object-contain mix-blend-multiply opacity-90 pointer-events-none">
            </div>

        </section>

        <section class="relative bg-white py-24 sm:py-32 px-4 sm:px-6 border-t border-gray-100 overflow-hidden">

            <div class="absolute inset-0 z-0 opacity-[0.03] bg-[radial-gradient(#000_1px,transparent_1px)] [background-size:24px_24px]"></div>

            <div class="relative z-10 max-w-5xl mx-auto text-center flex flex-col items-center">

                <header class="mb-8 flex flex-col items-center">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-[#FBF6F1] text-[#e26a35] text-sm font-bold tracking-widest uppercase mb-6 shadow-sm border border-[#e26a35]/10">
                        The Problem
                    </span>

                    <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-[1.1] pb-2">
                        Throw away your <br class="hidden sm:block">
                        <span class="relative inline-block mt-2">
                            messy spreadsheets.

                            <svg class="absolute w-full h-3 -bottom-2 left-0 text-[#e26a35] opacity-80 overflow-visible" viewBox="0 0 100 10" preserveAspectRatio="none" aria-hidden="true">
                                <path d="M 2 5 Q 50 10 98 4" stroke="currentColor" stroke-width="4" fill="transparent" stroke-linecap="round" />
                            </svg>
                        </span>
                    </h2>
                </header>

                <article class="max-w-2xl mx-auto relative mt-4">
                    <p class="text-lg sm:text-xl md:text-2xl text-gray-600 font-medium leading-relaxed">
                        Tracking hundreds of applications by hand is a massive waste of time. It causes you to lose links, forget follow-ups, and deal with painful ghosting. Stop fighting with rows and columns. Let our system handle the organization so you can focus on getting the offer.
                    </p>
                </article>

                <div aria-hidden="true" class="mt-16 w-full max-w-2xl mx-auto flex flex-col gap-3 opacity-60 select-none pointer-events-none">
                    <div class="h-10 border border-gray-200 rounded-lg bg-gray-50 flex items-center px-4 w-full transform -translate-x-4">
                        <div class="h-2 w-1/4 bg-gray-300 rounded-full mr-4"></div>
                        <div class="h-2 w-1/3 bg-gray-200 rounded-full"></div>
                    </div>
                    <div class="h-10 border border-gray-200 rounded-lg bg-gray-50 flex items-center px-4 w-[90%] mx-auto">
                        <div class="h-2 w-1/3 bg-gray-300 rounded-full mr-4"></div>
                        <div class="h-2 w-1/2 bg-gray-200 rounded-full"></div>
                    </div>
                    <div class="h-12 border border-[#e26a35]/40 rounded-lg bg-[#FBF6F1] flex items-center px-4 w-[95%] ml-auto shadow-md relative transform translate-x-2">
                        <div class="absolute -left-1 w-2 h-6 bg-[#e26a35] rounded-r-md"></div>
                        <div class="h-2.5 w-1/4 bg-[#e26a35]/70 rounded-full mr-4"></div>
                        <div class="h-2.5 w-1/2 bg-[#e26a35]/40 rounded-full"></div>
                    </div>
                </div>

            </div>
        </section>

        <section class="relative bg-gray-50 py-24 sm:py-32 px-4 sm:px-6 border-t border-gray-100 font-sans overflow-hidden">
            <div class="max-w-6xl mx-auto">

                <header class="text-center mb-20 sm:mb-28 flex flex-col items-center">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-white text-[#e26a35] text-sm font-bold tracking-widest uppercase mb-6 shadow-sm border border-gray-100">
                        How It Works
                    </span>
                    <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-[1.1]">
                        The grind, <span class="text-[#e26a35] relative inline-block">
                            simplified.
                            <svg class="absolute w-full h-3 -bottom-3 left-0 text-[#e26a35] opacity-80 overflow-visible" viewBox="0 0 100 10" preserveAspectRatio="none" aria-hidden="true">
                                <path d="M 5 5 Q 50 10 95 3" stroke="currentColor" stroke-width="4" fill="transparent" stroke-linecap="round" />
                            </svg>
                        </span>
                    </h2>
                </header>

                <div class="relative w-full max-w-5xl mx-auto">

                    <div class="hidden md:block absolute top-[2.5rem] left-[16.66%] right-[16.66%] border-t-2 border-dashed border-gray-300 z-0" aria-hidden="true"></div>
                    <div class="md:hidden absolute top-[2.5rem] bottom-[2.5rem] left-[50%] -translate-x-1/2 border-l-2 border-dashed border-gray-300 z-0" aria-hidden="true"></div>

                    <div class="relative z-10 flex flex-col md:flex-row gap-16 md:gap-8 justify-between">

                        <div class="flex-1 relative group cursor-default flex flex-col">
                            <div class="w-20 h-20 mx-auto bg-white border-[6px] border-gray-50 rounded-full flex items-center justify-center text-4xl font-black text-[#e26a35] shadow-[0_4px_20px_rgba(226,106,53,0.15)] relative z-20 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                                1
                            </div>
                            <article class="flex-1 mt-6 bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-gray-100 group-hover:shadow-xl group-hover:-translate-y-2 transition-all duration-300 text-center relative z-10">
                                <h3 class="text-xl sm:text-2xl font-bold text-[#e26a35] mb-4">Upload your resume.</h3>
                                <p class="text-gray-600 font-medium leading-relaxed">
                                    Drop your file into our smart resume parser. We automatically extract your history to build profiles.
                                </p>
                            </article>
                        </div>

                        <div class="flex-1 relative group cursor-default flex flex-col">
                            <div class="w-20 h-20 mx-auto bg-white border-[6px] border-gray-50 rounded-full flex items-center justify-center text-4xl font-black text-[#e26a35] shadow-[0_4px_20px_rgba(226,106,53,0.15)] relative z-20 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                                2
                            </div>
                            <article class="flex-1 mt-6 bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-gray-100 group-hover:shadow-xl group-hover:-translate-y-2 transition-all duration-300 text-center relative z-10">
                                <h3 class="text-xl sm:text-2xl font-bold text-[#e26a35] mb-4">Track applications.</h3>
                                <p class="text-gray-600 font-medium leading-relaxed">
                                    Manage your hunt from applied to hired. Let our visual application tracker organize your daily tasks.
                                </p>
                            </article>
                        </div>

                        <div class="flex-1 relative group cursor-default flex flex-col">
                            <div class="w-20 h-20 mx-auto bg-white border-[6px] border-gray-50 rounded-full flex items-center justify-center text-4xl font-black text-[#e26a35] shadow-[0_4px_20px_rgba(226,106,53,0.15)] relative z-20 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                                3
                            </div>
                            <article class="flex-1 mt-6 bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-gray-100 group-hover:shadow-xl group-hover:-translate-y-2 transition-all duration-300 text-center relative z-10">
                                <h3 class="text-xl sm:text-2xl font-bold text-[#e26a35] mb-4">Crush interviews.</h3>
                                <p class="text-gray-600 font-medium leading-relaxed">
                                    Practice with our AI mock interview assistant. We use the job description to prepare your answers.
                                </p>
                            </article>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <section class="py-24 sm:py-32 bg-white font-sans relative z-20 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">

                <header class="text-center mb-16 sm:mb-20">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-[#FBF6F1] text-[#e26a35] text-sm font-bold tracking-widest uppercase mb-6 border border-[#e26a35]/10 shadow-sm">
                        Platform Features
                    </span>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-[1.1]">
                        Everything you need.<br>
                        <span class="text-[#e26a35]">Nothing you don't.</span>
                    </h2>
                </header>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">

                    <article class="lg:col-span-8 bg-[#FBF6F1] rounded-[2rem] sm:rounded-[2.5rem] p-8 sm:p-12 border border-[#e26a35]/10 flex flex-col md:flex-row items-center justify-between overflow-hidden group">

                        <div class="w-full md:w-1/2 z-10 md:pr-8 mb-8 md:mb-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-full flex items-center justify-center text-lg sm:text-xl font-black text-[#e26a35] shadow-sm mb-6">1</div>
                            <h3 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                                Drop your resume.<br>
                                <span class="text-[#e26a35]">We read the rest.</span>
                            </h3>
                            <p class="text-base sm:text-lg text-gray-600 font-medium leading-relaxed">
                                Skip the manual entry. Upload your document and let our smart parser instantly extract your experience to build your profile.
                            </p>
                        </div>

                        <div class="w-full md:w-1/2 flex justify-center md:justify-end relative">
                            <img src="{{ asset('images/landing/feature-smart-scanner.webp') }}"
                                alt="A rough ink sketch of a robotic arm scanning a stack of papers to represent automated resume parsing"
                                loading="lazy"
                                decoding="async"
                                class="w-full max-w-[240px] sm:max-w-[300px] object-contain mix-blend-multiply opacity-90 transform-gpu will-change-transform group-hover:scale-105 group-hover:rotate-2 transition-transform duration-300 ease-out">
                        </div>

                    </article>

                    <article class="lg:col-span-4 bg-white rounded-[2rem] sm:rounded-[2.5rem] p-8 sm:p-12 border border-gray-200 shadow-sm flex flex-col justify-between overflow-hidden group">

                        <div class="z-10 relative">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-50 rounded-full flex items-center justify-center text-lg sm:text-xl font-black text-[#e26a35] border border-gray-100 mb-6">2</div>
                            <h3 class="text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
                                Stop guessing.<br>
                                <span class="text-[#e26a35]">See your match.</span>
                            </h3>
                            <p class="text-base sm:text-lg text-gray-600 font-medium leading-relaxed">
                                Know exactly where you stand. We compare your profile against the job description to calculate your exact match percentage.
                            </p>
                        </div>

                        <div class="flex justify-center mt-8 sm:mt-12 relative z-10">
                            <img src="{{ asset('images/landing/feature-perfect-match.webp') }}"
                                alt="A rough ink sketch of a target board with an arrow hitting dead center to represent exact job match percentages"
                                loading="lazy"
                                decoding="async"
                                class="w-full max-w-[200px] sm:max-w-[240px] object-contain mix-blend-multiply opacity-90 transform-gpu will-change-transform group-hover:scale-105 transition-transform duration-300 ease-out">
                        </div>

                    </article>

                    <article class="lg:col-span-12 bg-white rounded-[2rem] sm:rounded-[2.5rem] p-8 sm:p-12 lg:p-16 border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between overflow-hidden group">

                        <div class="w-full md:w-5/12 z-10 order-2 md:order-1 mt-10 md:mt-0 md:pr-10">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#FBF6F1] rounded-full flex items-center justify-center text-lg sm:text-xl font-black text-[#e26a35] border border-[#e26a35]/20 mb-6 shadow-sm">3</div>
                            <h3 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-6 leading-[1.1]">
                                Practice with AI.<br>
                                <span class="text-[#e26a35]">Perfect your answers.</span>
                            </h3>
                            <p class="text-base sm:text-xl text-gray-600 font-medium leading-relaxed">
                                Do not let a bad interview ruin your chances. Run through automated mock sessions tailored specifically to your target role and get instant, actionable feedback.
                            </p>
                        </div>

                        <div class="w-full md:w-7/12 flex justify-center md:justify-end order-1 md:order-2 relative">
                            <img src="{{ asset('images/landing/feature-ai-interview.webp') }}"
                                alt="A rough ink sketch of a studio microphone surrounded by speech bubbles representing AI mock interview practice"
                                loading="lazy"
                                decoding="async"
                                class="relative z-10 w-full max-w-[260px] sm:max-w-md lg:max-w-lg object-contain mix-blend-multiply opacity-90 transform-gpu will-change-transform group-hover:-translate-y-2 transition-transform duration-300 ease-out">
                        </div>

                    </article>

                </div>
            </div>
        </section>

        <x-faq-section />

        <x-footer />

    </main>

</body>

</html>