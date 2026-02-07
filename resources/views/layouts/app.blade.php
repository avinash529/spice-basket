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
        @php
            $isAdmin = request()->routeIs('admin.*');
        @endphp
        <div class="min-h-screen {{ $isAdmin ? 'relative overflow-hidden' : 'bg-stone-50' }}">
            @if($isAdmin)
                <div aria-hidden="true" class="pointer-events-none absolute -top-24 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-amber-200/50 blur-3xl"></div>
                <div aria-hidden="true" class="pointer-events-none absolute top-40 right-[-7rem] h-80 w-80 rounded-full bg-emerald-200/50 blur-3xl"></div>
            @endif
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="{{ $isAdmin ? 'bg-white/80 backdrop-blur border-b border-white/70' : 'bg-white/80 backdrop-blur border-b border-white/70' }}">
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
