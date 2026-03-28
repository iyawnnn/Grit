<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Grit') }} - Dashboard</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="bg-white text-black antialiased overflow-hidden flex flex-col h-screen" x-data="{ sidebarOpen: false }">
        
        <header class="flex items-center justify-between h-14 px-4 sm:px-6 border-b border-gray-200 shrink-0 bg-white z-20">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-black focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="/images/grit-logo.svg" alt="Grit logo" class="h-5 w-auto">
                    <span class="text-sm font-bold tracking-tight text-black">Grit</span>
                </a>
                
                <div class="hidden md:flex items-center gap-1 ml-6 pl-6 border-l border-gray-200 h-6">
                    <span class="text-sm font-medium text-gray-500 hover:text-black cursor-pointer transition-colors">{{ Auth::user()->name }}</span>
                    <span class="text-gray-300 mx-1">/</span>
                    <span class="text-sm font-medium text-black">Dashboard</span>
                </div>
            </div>

            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 focus:outline-none">
                            <img class="w-7 h-7 rounded-full bg-gray-100 border border-gray-200" src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=fff&background=000' }}" alt="{{ Auth::user()->name }}" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-medium text-black">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="text-sm text-gray-700 hover:bg-gray-50 hover:text-black">
                            Settings
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-sm text-gray-700 hover:bg-gray-50 hover:text-black">
                                Log out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">
            @include('layouts.navigation')

            <main class="flex-1 overflow-y-auto bg-white p-4 sm:p-6 lg:p-8 w-full">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>