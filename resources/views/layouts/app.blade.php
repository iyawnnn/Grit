<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Grit') }} - Career Co-pilot</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-[#f9fafb] flex h-screen w-full overflow-hidden"
    x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/20 backdrop-blur-sm lg:hidden"
        @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="absolute lg:relative z-50 inset-y-0 left-0 w-64 bg-white border-r border-gray-200 flex flex-col transition-transform duration-300 lg:translate-x-0 flex-shrink-0">

        <div class="flex items-center gap-3 h-16 px-6">
            <img src="{{ asset('images/grit-logo.svg') }}" alt="Grit Logo" class="w-7 h-7 object-contain">
            <span class="text-lg font-bold tracking-tight text-gray-900">Grit</span>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            <div class="text-[11px] font-semibold text-gray-400 mb-2 px-3 tracking-wider uppercase">Main Menu</div>

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-gray-900' : 'text-gray-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('applications.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('applications.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('applications.*') ? 'text-gray-900' : 'text-gray-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Applications
            </a>

            <a href="{{ route('resumes.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('resumes.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('resumes.*') ? 'text-gray-900' : 'text-gray-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Resumes
            </a>
        </nav>

        <div class="p-4 space-y-1 border-t border-gray-100">
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-3 py-2 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    class="w-full flex items-center gap-3 px-3 py-2 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 lg:px-8 shrink-0">
            <div class="flex items-center gap-4 flex-1">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-gray-500 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div
                    class="hidden sm:flex relative items-center w-full max-w-sm h-9 rounded-md bg-gray-50 border border-gray-200 focus-within:bg-white focus-within:border-[#e26a35]/40 focus-within:ring-1 focus-within:ring-[#e26a35] transition-all overflow-hidden">
                    <div class="pl-3 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text"
                        class="h-full w-full outline-none text-sm text-gray-900 bg-transparent border-none focus:ring-0 pl-2 pr-4 placeholder-gray-400"
                        placeholder="Search..." />
                </div>
            </div>

            <div
                class="flex items-center gap-3 ml-auto cursor-pointer hover:bg-gray-50 p-1.5 rounded-lg transition-colors">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-sm font-semibold text-gray-900 leading-tight">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-gray-500">{{ auth()->user()->email }}</span>
                </div>

                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="Profile"
                        class="h-8 w-8 rounded-full border border-gray-200 object-cover">
                @else
                    <div
                        class="h-8 w-8 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-sm font-bold text-gray-600">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 lg:p-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>