<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UnderPass') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-black text-zinc-100 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 bg-black">
            
            <div class="mb-8">
                <a href="/" class="text-3xl font-black tracking-tighter uppercase italic">
                    Under<span class="text-purple-500">Pass</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-zinc-900/30 border border-zinc-800 shadow-[0_0_50px_-12px_rgba(168,85,247,0.1)] overflow-hidden sm:rounded-2xl backdrop-blur-sm">
                {{ $slot }}
            </div>

            <div class="mt-8 text-[9px] font-black text-zinc-700 uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} Community Protocol
            </div>
        </div>
    </body>
</html>