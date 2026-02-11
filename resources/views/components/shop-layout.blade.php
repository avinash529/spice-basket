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
        <div class="min-h-screen relative overflow-hidden flex flex-col">
            <div aria-hidden="true" class="pointer-events-none absolute -top-24 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-amber-200/50 blur-3xl"></div>
            <div aria-hidden="true" class="pointer-events-none absolute top-32 right-[-6rem] h-72 w-72 rounded-full bg-emerald-200/50 blur-3xl"></div>
            <header class="sticky top-0 z-30 border-b border-white/70 bg-white/90 backdrop-blur">
                <div class="bg-emerald-700 text-emerald-50 text-xs">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between gap-3">
                        <p>Free delivery across India on orders above INR 1500</p>
                        <p class="hidden sm:block">We ship internationally | 100% secure checkout</p>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 gap-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold text-lg shrink-0">
                            <x-application-logo class="h-10 w-10" />
                            <span class="tracking-tight">Spice Basket</span>
                        </a>
                        <nav class="hidden lg:flex items-center gap-6 text-sm flex-1 justify-center">
                            <a class="hover:text-emerald-600" href="{{ route('products.index') }}">Products</a>
                            <a class="hover:text-emerald-600" href="{{ route('spices.guide') }}">List of Spices</a>
                            <a class="hover:text-emerald-600" href="{{ route('offers.index') }}">Latest Offer</a>
                            <a class="hover:text-emerald-600" href="{{ route('gift-boxes.index') }}">Gift Boxes</a>
                            <a class="hover:text-emerald-600" href="{{ route('blog.index') }}">Blog</a>
                            <a class="hover:text-emerald-600" href="{{ route('cart.index') }}">Cart ({{ $cartCount }})</a>
                            @auth
                                <a class="hover:text-emerald-600" href="{{ route('profile.edit') }}">Profile</a>
                                <a class="hover:text-emerald-600" href="{{ route('dashboard') }}">My Orders</a>
                                @if(auth()->user()->isAdmin())
                                    <a class="hover:text-emerald-600" href="{{ route('admin.dashboard') }}">Admin</a>
                                @endif
                            @endauth
                        </nav>
                        <div class="flex items-center gap-3 text-sm whitespace-nowrap shrink-0">
                            <a class="lg:hidden text-emerald-700 hover:text-emerald-600" href="{{ route('cart.index') }}">Cart ({{ $cartCount }})</a>
                            @guest
                                <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('login') }}">Login</a>
                                <a class="rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm hover:bg-emerald-500" href="{{ route('register') }}">Create account</a>
                            @else
                                <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('profile.edit') }}">Profile</a>
                                <span class="hidden sm:inline text-gray-600">Hi, {{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="text-emerald-700 hover:text-emerald-600" type="submit">Logout</button>
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="border-t border-stone-100 lg:hidden">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 text-sm flex items-center gap-5 overflow-x-auto whitespace-nowrap">
                        <a class="hover:text-emerald-600" href="{{ route('products.index') }}">Products</a>
                        <a class="hover:text-emerald-600" href="{{ route('spices.guide') }}">Spices</a>
                        <a class="hover:text-emerald-600" href="{{ route('offers.index') }}">Offers</a>
                        <a class="hover:text-emerald-600" href="{{ route('gift-boxes.index') }}">Gift Boxes</a>
                        <a class="hover:text-emerald-600" href="{{ route('blog.index') }}">Blog</a>
                        @auth
                            <a class="hover:text-emerald-600" href="{{ route('profile.edit') }}">Profile</a>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="relative flex-1">
                {{ $slot }}
            </main>

            <section class="border-y border-stone-200/80 bg-white/80">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-stone-100 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-900">Free Delivery Across India</p>
                        <p class="mt-1 text-sm text-stone-600">Available on orders above INR 1500.</p>
                    </div>
                    <div class="rounded-2xl border border-stone-100 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-900">International Shipping</p>
                        <p class="mt-1 text-sm text-stone-600">Packed safely for worldwide delivery.</p>
                    </div>
                    <div class="rounded-2xl border border-stone-100 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-900">Secure Checkout</p>
                        <p class="mt-1 text-sm text-stone-600">UPI, cards, and trusted payment gateways.</p>
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
                            <li><a class="hover:text-white" href="{{ route('spices.guide') }}">List of Spices</a></li>
                            <li><a class="hover:text-white" href="{{ route('offers.index') }}">Latest Offer</a></li>
                            <li><a class="hover:text-white" href="{{ route('gift-boxes.index') }}">Gift Boxes</a></li>
                            <li><a class="hover:text-white" href="{{ route('blog.index') }}">Blog</a></li>
                            <li><a class="hover:text-white" href="{{ route('corporate-gifts.index') }}">Corporate Gift Boxes</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-[0.12em] text-stone-100">Policies</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li><a class="hover:text-white" href="{{ route('policies.shipping') }}">Shipping Policy</a></li>
                            <li><a class="hover:text-white" href="{{ route('policies.refund') }}">Refund Policy</a></li>
                            <li><a class="hover:text-white" href="{{ route('policies.privacy') }}">Privacy Policy</a></li>
                            <li><a class="hover:text-white" href="{{ route('policies.terms') }}">Terms & Conditions</a></li>
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
                        <p>Payments accepted: UPI, Visa, Mastercard, Wallets</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
