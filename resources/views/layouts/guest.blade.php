<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Spice Basket') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700&family=manrope:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-stone-50 text-stone-900">
        <div class="min-h-screen relative overflow-hidden">
            <div aria-hidden="true" class="pointer-events-none absolute -top-24 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-amber-200/50 blur-3xl"></div>
            <div aria-hidden="true" class="pointer-events-none absolute top-40 right-[-7rem] h-80 w-80 rounded-full bg-emerald-200/50 blur-3xl"></div>

            <div class="relative mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
                <a href="{{ route('home') }}" class="mb-6 inline-flex items-center gap-3 sm:mb-8">
                    <x-application-logo class="h-10 w-10" />
                    <span class="text-lg font-semibold tracking-tight text-stone-900">Spice Basket</span>
                </a>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
