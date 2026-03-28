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

<body class="font-sans antialiased bg-[#f4f5f7] text-black h-screen flex overflow-hidden p-6 gap-6">

    <aside class="w-64 bg-white shadow-sm rounded-3xl flex flex-col overflow-hidden hidden md:flex">
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#e26a35] flex items-center justify-center text-white font-bold text-xl">
                G
            </div>
            <span class="text-xl font-bold tracking-tight">Grit.</span>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2">
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 bg-[#e26a35]/10 text-[#e26a35] rounded-2xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-2xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Applications
            </a>

            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-2xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profile Profile
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">

        <header class="h-16 bg-white shadow-sm rounded-3xl flex items-center justify-between px-6 mb-6">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold tracking-tight text-black">Grit Co-pilot</h1>
            </div>

            <div class="relative w-96 hidden sm:block">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text"
                    class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl text-sm placeholder-gray-400 focus:ring-2 focus:ring-[#e26a35] transition-shadow"
                    placeholder="Search applications...">
            </div>

            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-400 hover:text-[#e26a35] transition-colors relative">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-2 w-2 h-2 bg-[#e26a35] rounded-full"></span>
                </button>

                <img class="h-10 w-10 rounded-full object-cover shadow-sm border border-gray-100"
                    src="https://ui-avatars.com/api/?name=User&background=e26a35&color=fff"
                    alt="Logged in user profile picture">
            </div>
        </header>

        <main class="flex-1 overflow-y-auto pb-6 pr-2">
            {{ $slot }}
        </main>
    </div>
</body>

</html>