<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Spice Basket') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        spice: {
                            orange: '#F05423', // The specific vibrant orange from the screenshot
                            light: '#FFF5F0', // Very light orange background
                            gray: '#F8F8F8',  // Light gray background
                            text: '#1A1A1A',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-900 bg-[#F9F9F9]">

    <!-- Header -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-2">
                <x-application-logo class="h-8 w-8" />
                <span class="font-heading font-bold text-xl tracking-tight text-gray-900">Spice Basket</span>
            </a>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-xl mx-8 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" class="w-full bg-gray-100 border-none rounded-lg py-3 pl-12 pr-4 text-sm font-medium focus:ring-2 focus:ring-spice-orange focus:bg-white transition-colors placeholder-gray-400" placeholder="Search for spices, blends, oils...">
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-8">
                <div class="hidden lg:flex items-center gap-6 text-sm font-semibold text-gray-600">
                    <a href="#" class="hover:text-spice-orange transition">Shop</a>
                    <a href="#" class="hover:text-spice-orange transition">Our Story</a>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Wishlist -->
                    <a href="#" class="relative text-gray-800 hover:text-spice-orange transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span class="absolute -top-2 -right-2 bg-spice-orange text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">4</span>
                    </a>
                    <!-- Cart -->
                    <a href="#" class="relative text-gray-800 hover:text-spice-orange transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        <span class="absolute -top-2 -right-2 bg-spice-orange text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                    </a>
                    <!-- Profile -->
                    <a href="{{ route('login') }}" class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center text-spice-orange hover:bg-spice-orange hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-10">
        
        <!-- Page Title & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-2">My Wishlist</h1>
                <p class="text-gray-500 font-medium">You have 4 items saved in your wishlist.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="flex items-center gap-2 px-6 py-3 bg-orange-50 text-spice-orange font-bold rounded-lg hover:bg-orange-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    Share Wishlist
                </button>
                <button class="flex items-center gap-2 px-6 py-3 bg-spice-orange text-white font-bold rounded-lg shadow-lg hover:bg-orange-600 transition shadow-orange-500/30">
                    Add All to Cart
                </button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition group relative border border-gray-100">
                <button class="absolute top-4 right-4 z-10 bg-white rounded-full p-1.5 shadow-sm text-gray-400 hover:text-red-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="relative h-56 mb-4 overflow-hidden rounded-xl bg-[#F6F6F6] flex items-center justify-center">
                    <img src="{{ asset('images/cloves.png') }}" alt="Cloves" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="space-y-4 px-2 pb-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-heading font-bold text-lg text-gray-900 leading-tight mb-1">Idukki Cloves</h3>
                            <p class="text-xs text-gray-500 font-medium italic">Sun-dried and hand-picked</p>
                        </div>
                        <span class="bg-green-50 text-green-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">In Stock</span>
                    </div>
                
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 font-semibold uppercase">100g Pack</p>
                        <p class="font-heading font-bold text-2xl text-spice-orange">₹320</p>
                    </div>

                    <button class="w-full py-3 bg-spice-orange text-white font-bold rounded-lg hover:bg-orange-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Card 2 -->
             <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition group relative border border-gray-100">
                <button class="absolute top-4 right-4 z-10 bg-white rounded-full p-1.5 shadow-sm text-gray-400 hover:text-red-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="relative h-56 mb-4 overflow-hidden rounded-xl bg-[#F6F6F6] flex items-center justify-center">
                    <img src="{{ asset('images/black_pepper.png') }}" alt="Black Pepper" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="space-y-4 px-2 pb-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-heading font-bold text-lg text-gray-900 leading-tight mb-1">Wayanad Black Pepper</h3>
                            <p class="text-xs text-gray-500 font-medium italic">Pungent and aromatic</p>
                        </div>
                        <span class="bg-green-50 text-green-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">In Stock</span>
                    </div>
                
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 font-semibold uppercase">100g Pack</p>
                        <p class="font-heading font-bold text-2xl text-spice-orange">₹250</p>
                    </div>

                    <button class="w-full py-3 bg-spice-orange text-white font-bold rounded-lg hover:bg-orange-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
             <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition group relative border border-gray-100">
                <button class="absolute top-4 right-4 z-10 bg-white rounded-full p-1.5 shadow-sm text-gray-400 hover:text-red-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="relative h-56 mb-4 overflow-hidden rounded-xl bg-[#F6F6F6] flex items-center justify-center">
                    <img src="{{ asset('images/turmeric.png') }}" alt="Turmeric" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="space-y-4 px-2 pb-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-heading font-bold text-lg text-gray-900 leading-tight mb-1">Alleppey Turmeric</h3>
                            <p class="text-xs text-gray-500 font-medium italic">High curcumin content</p>
                        </div>
                        <span class="bg-green-50 text-green-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">In Stock</span>
                    </div>
                
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 font-semibold uppercase">200g Pack</p>
                        <p class="font-heading font-bold text-2xl text-spice-orange">₹180</p>
                    </div>

                    <button class="w-full py-3 bg-spice-orange text-white font-bold rounded-lg hover:bg-orange-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Card 4 -->
             <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition group relative border border-gray-100">
                <button class="absolute top-4 right-4 z-10 bg-white rounded-full p-1.5 shadow-sm text-gray-400 hover:text-red-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="relative h-56 mb-4 overflow-hidden rounded-xl bg-[#F6F6F6] flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1631553384214-724d2713f01b?q=80&w=600&auto=format&fit=crop" alt="Cardamom" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="space-y-4 px-2 pb-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-heading font-bold text-lg text-gray-900 leading-tight mb-1">Green Cardamom Pods</h3>
                            <p class="text-xs text-gray-500 font-medium italic">Grade A premium quality</p>
                        </div>
                        <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">Low Stock</span>
                    </div>
                
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 font-semibold uppercase">50g Pack</p>
                        <p class="font-heading font-bold text-2xl text-spice-orange">₹450</p>
                    </div>

                    <button class="w-full py-3 bg-spice-orange text-white font-bold rounded-lg hover:bg-orange-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Add to Cart
                    </button>
                </div>
            </div>

        </div>

        <!-- You May Also Like Section -->
        <section class="mt-20">
            <h2 class="font-heading font-bold text-2xl text-gray-900 mb-8">You May Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                 <!-- Large Card 1 -->
                 <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition cursor-pointer group">
                    <div class="w-40 h-40 rounded-2xl overflow-hidden shrink-0">
                         <img src="https://images.unsplash.com/photo-1599909631731-9a74dd5cldf2?q=80&w=400&auto=format&fit=crop" alt="Star Anise" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="flex-1">
                        <h3 class="font-heading font-bold text-xl text-gray-900 mb-2">Premium Star Anise</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">Exotic, licorice-like flavor perfect for biryanis and stews. Hand-selected whole stars.</p>
                        <p class="font-bold text-spice-orange text-xl">₹160</p>
                    </div>
                 </div>

                 <!-- Large Card 2 -->
                 <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition cursor-pointer group">
                    <div class="w-40 h-40 rounded-2xl overflow-hidden shrink-0">
                         <img src="https://images.unsplash.com/photo-1601314169736-21a4f009e530?q=80&w=400&auto=format&fit=crop" alt="Sambar Powder" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="flex-1">
                        <h3 class="font-heading font-bold text-xl text-gray-900 mb-2">Traditional Sambar Powder</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">Authentic Kerala blend with roasted coriander, chilis and fenugreek. No preservatives.</p>
                        <p class="font-bold text-spice-orange text-xl">₹120</p>
                    </div>
                 </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-20 pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="space-y-6">
                    <a href="#" class="flex items-center gap-2">
                        <x-application-logo class="h-6 w-6" />
                        <span class="font-heading font-bold text-lg text-gray-900">Spice Basket</span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Dedicated to bringing the finest, ethically sourced spices from the small-hold farms of Kerala to your doorstep.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-6">Quick Links</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-spice-orange transition">About Us</a></li>
                        <li><a href="#" class="hover:text-spice-orange transition">Farmers Network</a></li>
                        <li><a href="#" class="hover:text-spice-orange transition">Wholesale Inquiry</a></li>
                        <li><a href="#" class="hover:text-spice-orange transition">Gift Cards</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-6">Customer Support</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-spice-orange transition">Shipping Policy</a></li>
                        <li><a href="#" class="hover:text-spice-orange transition">Returns & Refunds</a></li>
                        <li><a href="#" class="hover:text-spice-orange transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-spice-orange transition">Track Order</a></li>
                    </ul>
                </div>

                <!-- Connect -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-6">Connect with Us</h4>
                    <div class="flex gap-4 mb-6">
                        <a href="#" class="w-10 h-10 rounded-full bg-orange-50 text-spice-orange flex items-center justify-center hover:bg-spice-orange hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                        </a>
                         <a href="#" class="w-10 h-10 rounded-full bg-orange-50 text-spice-orange flex items-center justify-center hover:bg-spice-orange hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-orange-50 text-spice-orange flex items-center justify-center hover:bg-spice-orange hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        </a>
                    </div>
                    <p class="text-xs text-gray-500">
                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Wayanad, Kerala, India - 673122
                    </p>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Spice Basket E-Commerce. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
