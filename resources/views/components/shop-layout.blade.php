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

        <style>
            /* Modern Dropdown Styles */
            .dropdown-panel {
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(0, 0, 0, 0.06);
                box-shadow:
                    0 20px 60px rgba(0, 0, 0, 0.1),
                    0 4px 16px rgba(0, 0, 0, 0.05),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
            }
            .dropdown-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 14px;
                border-radius: 12px;
                font-size: 0.875rem;
                font-weight: 500;
                color: #44403c;
                transition: all 0.25s ease;
                position: relative;
            }
            .dropdown-item:hover {
                background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(5, 150, 105, 0.05));
                color: #047857;
                transform: translateX(4px);
            }
            .dropdown-item .dd-icon {
                width: 32px;
                height: 32px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: transform 0.3s ease;
            }
            .dropdown-item:hover .dd-icon {
                transform: scale(1.1);
            }
            .dropdown-item .dd-arrow {
                margin-left: auto;
                opacity: 0;
                transform: translateX(-6px);
                transition: all 0.25s ease;
                color: #10b981;
            }
            .dropdown-item:hover .dd-arrow {
                opacity: 1;
                transform: translateX(0);
            }
            .dropdown-divider {
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(0,0,0,0.06), transparent);
                margin: 6px 8px;
            }
            .dropdown-label {
                font-size: 0.65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #a8a29e;
                padding: 8px 14px 4px;
            }
            .dropdown-trigger {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-weight: 600;
                font-size: 0.875rem;
                padding: 6px 14px;
                border-radius: 50px;
                transition: all 0.3s ease;
            }
            .dropdown-trigger:hover {
                background: rgba(16, 185, 129, 0.08);
                color: #059669;
            }
            .dropdown-trigger .chevron {
                transition: transform 0.3s cubic-bezier(.22,1,.36,1);
            }
            .logout-item {
                display: flex;
                align-items: center;
                gap: 12px;
                width: 100%;
                padding: 10px 14px;
                border-radius: 12px;
                font-size: 0.875rem;
                font-weight: 500;
                color: #e11d48;
                transition: all 0.25s ease;
                text-align: left;
                background: none;
                border: none;
                cursor: pointer;
            }
            .logout-item:hover {
                background: rgba(225, 29, 72, 0.06);
                transform: translateX(4px);
            }

            /* Mobile dropdown grid */
            .mobile-grid-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 14px;
                border-radius: 14px;
                border: 1px solid rgba(0,0,0,0.06);
                background: white;
                font-size: 0.85rem;
                font-weight: 500;
                color: #44403c;
                transition: all 0.3s ease;
            }
            .mobile-grid-item:hover {
                border-color: rgba(16, 185, 129, 0.3);
                background: rgba(16, 185, 129, 0.04);
                color: #047857;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            }
            .mobile-grid-item .m-icon {
                width: 28px;
                height: 28px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 0.75rem;
            }
        </style>
    </head>
    <body class="antialiased bg-stone-50 text-stone-900">
        @php
            $cartCount = count(session('cart', []));
            $exploreLinks = [
                ['label' => 'Spices Guide', 'url' => route('spices.guide')],
                ['label' => 'Gift Boxes', 'url' => route('gift-boxes.index')],
                ['label' => 'Corporate Gifts', 'url' => route('corporate-gifts.index')],
                ['label' => 'Blog', 'url' => route('blog.index')],
            ];
        @endphp
        <div class="min-h-screen relative overflow-hidden flex flex-col">
            <div aria-hidden="true" class="pointer-events-none absolute -top-24 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-amber-200/50 blur-3xl"></div>
            <div aria-hidden="true" class="pointer-events-none absolute top-32 right-[-6rem] h-72 w-72 rounded-full bg-emerald-200/50 blur-3xl"></div>
            <header x-data="{ desktopMore: false, mobileMore: false, userMenu: false }" class="sticky top-0 z-30 border-b border-white/70 bg-white/90 backdrop-blur">
                <div class="bg-emerald-700 text-emerald-50 text-xs">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between gap-3">
                        <p>Free delivery across Kerala on orders above INR 1500</p>
                        <p class="hidden sm:block">Free delivery in Kerala | Cash on Delivery (COD) only</p>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 gap-3 sm:gap-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 font-semibold text-base sm:text-lg shrink-0">
                            <x-application-logo class="h-9 w-9 sm:h-10 sm:w-10" />
                            <span class="hidden sm:inline tracking-tight">Spice Basket</span>
                        </a>
                        <nav class="hidden lg:flex items-center gap-6 text-sm flex-1 justify-center">
                            <a class="{{ request()->routeIs('products.*') ? 'text-emerald-700 font-semibold' : 'text-stone-700 hover:text-emerald-600' }}" href="{{ route('products.index') }}">Products</a>
                            <a class="{{ request()->routeIs('offers.*') ? 'text-emerald-700 font-semibold' : 'text-stone-700 hover:text-emerald-600' }}" href="{{ route('offers.index') }}">Offers</a>

                            <div class="relative" @click.away="desktopMore = false">
                                <button
                                    type="button"
                                    @click="desktopMore = !desktopMore"
                                    class="dropdown-trigger text-stone-700"
                                    :class="{ 'bg-emerald-50 text-emerald-700': desktopMore }"
                                >
                                    Explore
                                    <svg class="h-4 w-4 chevron" :class="{ 'rotate-180': desktopMore }" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div
                                    x-show="desktopMore"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                    class="absolute left-1/2 z-40 mt-3 w-60 -translate-x-1/2 rounded-2xl dropdown-panel p-2"
                                >
                                    <p class="dropdown-label">Discover</p>
                                    @php
                                        $exploreIcons = [
                                            ['bg' => 'bg-emerald-100 text-emerald-700', 'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'],
                                            ['bg' => 'bg-amber-100 text-amber-700', 'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>'],
                                            ['bg' => 'bg-sky-100 text-sky-700', 'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'],
                                            ['bg' => 'bg-rose-100 text-rose-700', 'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>'],
                                        ];
                                    @endphp
                                    @foreach ($exploreLinks as $index => $link)
                                        <a href="{{ $link['url'] }}" class="dropdown-item">
                                            <span class="dd-icon {{ $exploreIcons[$index]['bg'] }}">{!! $exploreIcons[$index]['icon'] !!}</span>
                                            {{ $link['label'] }}
                                            <svg class="w-4 h-4 dd-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </nav>

                        <div class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm whitespace-nowrap shrink-0">
                            <a class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-emerald-700 hover:bg-emerald-100 sm:px-3 sm:py-1.5" href="{{ route('cart.index') }}">
                                Cart ({{ $cartCount }})
                            </a>

                            @guest
                                <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('login') }}">Login</a>
                                <a class="hidden sm:inline-flex rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm hover:bg-emerald-500" href="{{ route('register') }}">Create account</a>
                            @else
                                <div class="relative" @click.away="userMenu = false">
                                    <button
                                        type="button"
                                        @click="userMenu = !userMenu"
                                        class="dropdown-trigger rounded-full border border-stone-200 text-stone-700"
                                        :class="{ 'border-emerald-200 bg-emerald-50 text-emerald-700': userMenu }"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Account
                                        <svg class="h-4 w-4 chevron" :class="{ 'rotate-180': userMenu }" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div
                                        x-show="userMenu"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                        class="absolute right-0 z-40 mt-3 w-60 rounded-2xl dropdown-panel p-2"
                                    >
                                        <p class="dropdown-label">My Account</p>
                                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                            <span class="dd-icon bg-stone-100 text-stone-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                                            Profile
                                            <svg class="w-4 h-4 dd-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                        <a href="{{ route('dashboard') }}" class="dropdown-item">
                                            <span class="dd-icon bg-emerald-100 text-emerald-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></span>
                                            My Orders
                                            <svg class="w-4 h-4 dd-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                        @if(auth()->user()->isWholesale() || auth()->user()->isAdmin())
                                            <a href="{{ route('wholesale.index') }}" class="dropdown-item">
                                                <span class="dd-icon bg-amber-100 text-amber-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg></span>
                                                Wholesale
                                                <svg class="w-4 h-4 dd-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @endif
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                                <span class="dd-icon bg-violet-100 text-violet-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                                                Admin Dashboard
                                                <svg class="w-4 h-4 dd-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="logout-item" type="submit">
                                                <span class="dd-icon bg-rose-100 text-rose-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></span>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="border-t border-stone-100 lg:hidden">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 text-sm flex flex-wrap items-center gap-2">
                        <a class="rounded-full border border-stone-200 px-3 py-1.5 {{ request()->routeIs('products.*') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'text-stone-700 hover:bg-stone-100' }}" href="{{ route('products.index') }}">Products</a>
                        <a class="rounded-full border border-stone-200 px-3 py-1.5 {{ request()->routeIs('offers.*') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'text-stone-700 hover:bg-stone-100' }}" href="{{ route('offers.index') }}">Offers</a>
                        <button
                            type="button"
                            @click="mobileMore = !mobileMore"
                            class="rounded-full border border-stone-200 px-3 py-1.5 text-stone-700 hover:bg-stone-100"
                        >
                            More
                        </button>
                    </div>

                    <div
                        x-show="mobileMore"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="max-w-7xl mx-auto px-4 sm:px-6 pb-4"
                    >
                        <div class="grid grid-cols-2 gap-2">
                            @php
                                $mobileIcons = [
                                    '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
                                    '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>',
                                    '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
                                    '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>',
                                ];
                                $mobileBgs = ['bg-emerald-100 text-emerald-700', 'bg-amber-100 text-amber-700', 'bg-sky-100 text-sky-700', 'bg-rose-100 text-rose-700'];
                            @endphp
                            @foreach ($exploreLinks as $index => $link)
                                <a href="{{ $link['url'] }}" class="mobile-grid-item">
                                    <span class="m-icon {{ $mobileBgs[$index] }}">{!! $mobileIcons[$index] !!}</span>
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                            @auth
                                <a href="{{ route('profile.edit') }}" class="mobile-grid-item">
                                    <span class="m-icon bg-stone-100 text-stone-600"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                                    Profile
                                </a>
                                <a href="{{ route('dashboard') }}" class="mobile-grid-item">
                                    <span class="m-icon bg-emerald-100 text-emerald-700"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></span>
                                    My Orders
                                </a>
                                @if(auth()->user()->isWholesale() || auth()->user()->isAdmin())
                                    <a href="{{ route('wholesale.index') }}" class="mobile-grid-item">
                                        <span class="m-icon bg-amber-100 text-amber-700"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg></span>
                                        Wholesale
                                    </a>
                                @endif
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="mobile-grid-item">
                                        <span class="m-icon bg-violet-100 text-violet-700"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                                        Admin
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="mobile-grid-item">
                                    <span class="m-icon bg-emerald-100 text-emerald-700"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg></span>
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="mobile-grid-item">
                                    <span class="m-icon bg-sky-100 text-sky-700"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg></span>
                                    Create account
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <main class="relative flex-1">
                {{ $slot }}
            </main>

            <section class="border-y border-stone-200/80 bg-white/80">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-stone-100 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-900">Free Delivery Across Kerala</p>
                        <p class="mt-1 text-sm text-stone-600">Available on orders above INR 1500.</p>
                    </div>
                    <div class="rounded-2xl border border-stone-100 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-900">International Shipping</p>
                        <p class="mt-1 text-sm text-stone-600">Packed safely for worldwide delivery.</p>
                    </div>
                    <div class="rounded-2xl border border-stone-100 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-900">Cash on Delivery (COD)</p>
                        <p class="mt-1 text-sm text-stone-600">No online payment. Pay only at delivery.</p>
                    </div>
                </div>
            </section>

            <footer class="bg-stone-900 text-stone-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Spice Basket</h3>
                        <p class="mt-3 text-sm leading-6 text-stone-400">
                            Farm-direct Kerala spices with transparent sourcing, small-batch quality checks, and fast shipping.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-[0.12em] text-stone-100">Explore</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('spices.guide') }}">List of Spices</a></li>
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('offers.index') }}">Latest Offer</a></li>
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('gift-boxes.index') }}">Gift Boxes</a></li>
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('blog.index') }}">Blog</a></li>
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('corporate-gifts.index') }}">Corporate Gift Boxes</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-[0.12em] text-stone-100">Policies</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('policies.shipping') }}">Shipping Policy</a></li>
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('policies.refund') }}">Refund Policy</a></li>
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('policies.privacy') }}">Privacy Policy</a></li>
                            <li><a class="transition-colors hover:text-emerald-300" href="{{ route('policies.terms') }}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-[0.12em] text-stone-100">Follow</h3>
                        <p class="mt-3 text-sm">Facebook | Instagram | YouTube</p>
                        <p class="mt-5 text-sm text-stone-400">Over 1,000 5-star reviews from spice lovers.</p>
                    </div>
                </div>
                <div class="border-t border-stone-800">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-stone-500 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <p>&copy; {{ date('Y') }} Spice Basket. All rights reserved.</p>
                        <p>Payment mode: Cash on Delivery (COD) only</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
