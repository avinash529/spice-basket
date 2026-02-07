<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Spice Basket') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700&family=manrope:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-stone-50 text-stone-900">
        @php
            $cartCount = count(session('cart', []));
        @endphp
        <div class="min-h-screen relative overflow-hidden">
            <div aria-hidden="true" class="pointer-events-none absolute -top-24 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-amber-200/50 blur-3xl"></div>
            <div aria-hidden="true" class="pointer-events-none absolute top-32 right-[-6rem] h-72 w-72 rounded-full bg-emerald-200/50 blur-3xl"></div>
            <header class="sticky top-0 z-30 border-b border-white/70 bg-white/80 backdrop-blur">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 gap-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold text-lg shrink-0">
                            <x-application-logo class="h-10 w-10" />
                            <span class="tracking-tight">Spice Basket</span>
                        </a>
                        <nav class="hidden md:flex items-center gap-6 text-sm flex-1 justify-center">
                            <a class="hover:text-emerald-600" href="{{ route('products.index') }}">Products</a>
                            <a class="hover:text-emerald-600" href="{{ route('home') }}#categories">Categories</a>
                            <a class="hover:text-emerald-600" href="{{ route('cart.index') }}">Cart ({{ $cartCount }})</a>
                            @auth
                                <a class="hover:text-emerald-600" href="{{ route('dashboard') }}">My Orders</a>
                                @if(auth()->user()->isAdmin())
                                    <a class="hover:text-emerald-600" href="{{ route('admin.dashboard') }}">Admin</a>
                                @endif
                            @endauth
                        </nav>
                        <div class="flex items-center gap-3 text-sm whitespace-nowrap shrink-0">
                            @guest
                                <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('login') }}">Login</a>
                                <a class="rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm hover:bg-emerald-500" href="{{ route('register') }}">Create account</a>
                            @else
                                <span class="hidden sm:inline text-gray-600">Hi, {{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="text-emerald-700 hover:text-emerald-600" type="submit">Logout</button>
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </header>

            <main class="relative">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
