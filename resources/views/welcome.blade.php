<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grit Prototype</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md text-center">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Welcome to Grit</h1>
        <p class="text-gray-600 mb-8">Your personal application tracker.</p>

        <div class="flex flex-col space-y-4">
            <a href="/dashboard/login" class="bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition">
                Log In
            </a>
            <a href="/dashboard/register" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-md font-semibold hover:bg-gray-300 transition">
                Sign Up
            </a>
        </div>
    </div>
</body>
</html>