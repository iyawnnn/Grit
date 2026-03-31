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
    
    @livewireStyles
    @livewireScripts
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen w-full overflow-hidden bg-gray-100">

        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-gray-900/40 backdrop-blur-sm lg:hidden transform-gpu will-change-opacity"
            @click="sidebarOpen = false" style="display: none;"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-[150%] lg:translate-x-0'"
            class="-translate-x-[150%] lg:translate-x-0 fixed lg:relative z-50 my-3 ml-3 sm:my-4 sm:ml-4 lg:my-6 lg:ml-6 w-64 h-[calc(100vh-1.5rem)] sm:h-[calc(100vh-2rem)] lg:h-[calc(100vh-3rem)] bg-white rounded-2xl border border-gray-200/60 shadow-lg flex flex-col transition-transform duration-300 ease-out shrink-0 transform-gpu will-change-transform">

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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-2 space-y-1.5 overflow-y-auto mt-2">
                <div class="text-[11px] font-semibold text-gray-500 mb-3 px-3 tracking-wider uppercase">Menu</div>

                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#e26a35]' : 'text-gray-400 group-hover:text-gray-600' }} transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('applications.index') }}" @click="sidebarOpen = false"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('applications.index', 'applications.create', 'applications.show', 'applications.edit') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('applications.index', 'applications.create', 'applications.show', 'applications.edit') ? 'text-[#e26a35]' : 'text-gray-400 group-hover:text-gray-600' }} transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.084-.816 1.954-1.875 2.102a48.667 48.667 0 01-12.75 0c-1.059-.148-1.875-1.018-1.875-2.102v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                    Applications
                </a>

                <a href="{{ route('resumes.index') }}" @click="sidebarOpen = false"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('resumes.*') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('resumes.*') ? 'text-[#e26a35]' : 'text-gray-400 group-hover:text-gray-600' }} transition-colors"
                        aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                        </path>
                    </svg>
                    Resumes
                </a>

                <div class="text-[11px] font-semibold text-gray-500 mb-3 mt-6 px-3 tracking-wider uppercase pt-2">Analysis & Tracking</div>

                <a href="{{ route('matches.index') }}" @click="sidebarOpen = false"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('matches.*') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('matches.*') ? 'text-[#e26a35]' : 'text-gray-400 group-hover:text-gray-600' }} transition-colors"
                        aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z">
                        </path>
                    </svg>
                    Match Reports
                </a>

                <a href="{{ route('applications.board') }}" @click="sidebarOpen = false"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('applications.board') ? 'bg-[#e26a35]/10 text-[#e26a35]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <svg class="w-5 h-5 {{ request()->routeIs('applications.board') ? 'text-[#e26a35]' : 'text-gray-400 group-hover:text-gray-600' }} transition-colors"
                        aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.75v16.5M14.25 3.75v16.5" />
                    </svg>
                    
                    Job Board
                </a>
            </nav>

            <div class="mt-auto px-4 pb-5 pt-2">
                <div class="space-y-1 mb-4">
                    <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false"
                        class="group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl text-sm font-medium transition-colors">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors"
                            aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                        Settings
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="group w-full flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75">
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

        <div class="flex-1 h-screen overflow-y-auto scroll-smooth">
            <div class="flex flex-col min-h-full px-0 pb-0 sm:p-4 lg:p-6 gap-0 sm:gap-4 lg:gap-6">

                <div class="sticky top-0 z-40 lg:hidden pt-4 pb-2 px-3 bg-gray-100">
                    
                    <div class="flex items-center justify-between shrink-0 bg-white/80 backdrop-blur-md p-3 rounded-2xl shadow-sm border border-gray-200/80 transition-all duration-300">
                        <button @click="sidebarOpen = true" aria-label="Open menu"
                            class="p-2 text-gray-600 rounded-xl hover:bg-gray-50 hover:text-[#e26a35] transition-colors focus:outline-none focus:ring-2 focus:ring-[#e26a35]/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"></path>
                            </svg>
                        </button>

                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/grit-logo.svg') }}" alt="Grit Logo" width="24" height="24"
                                class="w-6 h-6 object-contain">
                            <span class="font-bold tracking-tight text-gray-900 text-lg">Grit</span>
                        </div>

                        <div class="w-10"></div>
                    </div>

                </div>

                <main class="flex-1 pb-10 lg:pb-0">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    <x-toast />
</body>

</html>