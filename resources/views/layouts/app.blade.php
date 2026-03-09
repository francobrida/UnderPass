<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @if (session('success'))
            <div class="max-w-7xl mx-auto mt-4 px-4">
                <div class="bg-green-900/50 border border-green-500 text-green-200 p-4 rounded-xl font-bold uppercase text-xs tracking-widest shadow-[0_0_15px_rgba(34,197,94,0.3)]">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="max-w-7xl mx-auto mt-4 px-4">
                <div class="bg-blue-900/50 border border-blue-500 text-blue-200 p-4 rounded-xl font-bold uppercase text-xs tracking-widest">
                    {{ session('info') }}
                </div>
            </div>
        @endif
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
