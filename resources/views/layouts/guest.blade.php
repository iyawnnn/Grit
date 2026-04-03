<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Welcome' }} | {{ config('app.name', 'Grit') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
</head>

<body class="relative font-sans text-brand-dark antialiased min-h-screen w-full overflow-x-hidden bg-white selection:bg-[#e26a35] selection:text-white">
    
    <a href="{{ url('/') }}" class="absolute top-6 left-6 md:top-8 md:left-8 z-50 inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-gray-500 bg-white/70 backdrop-blur-md border border-gray-200 rounded-full hover:bg-white hover:text-gray-900 hover:shadow-md hover:border-gray-300 hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#e26a35] focus:ring-offset-2">
        <svg class="w-4 h-4 transform transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Home
    </a>

    {{ $slot }}

    <x-toast />

    @livewireScripts
</body>

</html>