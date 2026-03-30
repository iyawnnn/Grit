<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="Grit is an AI-powered Career Co-pilot and applicant tracking system.">

    <title>{{ $title ?? 'Dashboard' }} | {{ config('app.name', 'Grit') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap">
    </noscript>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">

    <div x-data="{ sidebarOpen: false }"
        class="flex h-screen w-full overflow-hidden py-3 pl-3 sm:py-4 sm:pl-4 lg:py-6 lg:pl-6 gap-4 lg:gap-6">

        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-gray-900/40 backdrop-blur-sm lg:hidden transform-gpu will-change-opacity"
            @click="sidebarOpen = false" style="display: none;"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-[150%] lg:translate-x-0'"
            class="fixed lg:relative z-50 inset-y-3 left-3 sm:inset-y-4 sm:left-4 lg:inset-auto lg:left-auto w-64 h-[calc(100vh-1.5rem)] sm:h-[calc(100vh-2rem)] lg:h-full bg-white rounded-2xl border border-gray-200/60 shadow-lg flex flex-col transition-transform duration-300 ease-out shrink-0 transform-gpu will-change-transform">

            <div class="flex items-center justify-between mt-3 mx-3 mb-2 shrink-0">

                <div
                    class="group flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 border border-transparent transition-all duration-300 w-full cursor-pointer">

                    <div
                        class="bg-white p-1.5 rounded-lg shadow-sm border border-gray-200 shrink-0 transition-all duration-300 group-hover:shadow-md group-hover:border-[#e26a35]/30 overflow-hidden will-change-transform">
                        <img src="{{ asset('images/grit-logo.svg') }}" alt="Grit Logo" width="24" height="24"
                            class="w-6 h-6 object-contain transition-all duration-700 ease-in-out group-hover:rotate-[360deg] group-hover:scale-110">
                    </div>

                    <div class="flex flex-col min-w-0 flex-1 justify-center">
                        <span
                            class="text-sm font-bold text-gray-900 truncate leading-tight transition-colors duration-300 group-hover:text-[#e26a35]">Grit
                            Workspace</span>
                        <span
                            class="text-xs font-medium text-gray-600 truncate leading-tight -mt-0.5 transition-colors duration-300 group-hover:text-gray-700">Career
                            Co-pilot</span>
                    </div>
                </div>

                <button @click="sidebarOpen = false" aria-label="Close menu"
                    class="lg:hidden p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg ml-1 shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-2 space-y-1.5 overflow-y-auto mt-2">
                <div class="text-[11px] font-semibold text-gray-500 mb-3 px-3 tracking-wider uppercase">Menu</div>

                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#e26a35]' : 'text-gray-500' }}"
                        aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('applications.index') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('applications.*') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('applications.*') ? 'text-[#e26a35]' : 'text-gray-500' }}"
                        aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    Applications
                </a>

                <a href="{{ route('matches.index') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('matches.*') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('matches.*') ? 'text-[#e26a35]' : 'text-gray-500' }}"
                        aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Match Reports
                </a>

                <a href="{{ route('resumes.index') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('resumes.*') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('resumes.*') ? 'text-[#e26a35]' : 'text-gray-500' }}"
                        aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Resumes
                </a>
            </nav>

            <div class="mt-auto px-4 pb-5 pt-2">

                <div class="space-y-1 mb-4">
                    <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl text-sm font-medium transition-colors">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-red-500" aria-hidden="true" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

                <div class="h-px bg-gray-200 w-full mb-4"></div>

                <div class="flex items-center gap-3 px-2">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Profile" width="36" height="36"
                            class="h-9 w-9 rounded-full object-cover border border-gray-200 shrink-0">
                    @else
                        <div
                            class="h-9 w-9 rounded-full bg-[#e26a35]/10 border border-[#e26a35]/20 flex items-center justify-center text-sm font-bold text-[#e26a35] shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex flex-col min-w-0 flex-1">
                        <span class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</span>
                        <span class="text-[11px] text-gray-600 truncate">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 h-full relative">

            <div
                class="lg:hidden flex items-center justify-between mb-4 shrink-0 bg-white p-3 rounded-2xl shadow-sm border border-gray-200 mr-3 sm:mr-4 lg:mr-6">
                <button @click="sidebarOpen = true" aria-label="Open menu"
                    class="p-2 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/grit-logo.svg') }}" alt="Grit Logo" width="24" height="24"
                        class="w-6 h-6 object-contain">
                    <span class="font-bold tracking-tight text-gray-900 text-lg">Grit</span>
                </div>
                <div class="w-10"></div>
            </div>

            <main class="flex-1 overflow-y-auto scroll-smooth pb-10 lg:pb-0 pr-3 sm:pr-4 lg:pr-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <x-toast />
</body>

</html>