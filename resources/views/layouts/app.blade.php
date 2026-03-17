<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Underpass') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-black">
        <div class="min-h-screen bg-zinc-950">
            @include('layouts.navigation')

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mt-4 bg-zinc-900 border border-green-500 text-green-400 p-4 rounded-xl font-bold uppercase text-xs tracking-widest shadow-[0_0_15px_rgba(34,197,94,0.15)]">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="mt-4 bg-zinc-900 border border-blue-500 text-blue-300 p-4 rounded-xl font-bold uppercase text-xs tracking-widest">
                        {{ session('info') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="mt-4 bg-zinc-900 border border-red-500 text-red-400 p-4 rounded-xl font-bold uppercase text-xs tracking-widest">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            @isset($header)
                <header class="bg-zinc-900/50 border-b border-zinc-800 shadow-2xl">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-white">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="text-zinc-200">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>