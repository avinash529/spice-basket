<x-shop-layout>

    {{-- ── Inline animation styles (works with existing Tailwind setup) ── --}}
    <style>
        /* Scroll reveal animations */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .reveal-left {
            opacity: 0;
            transform: translateX(-60px);
            transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }

        .reveal-right {
            opacity: 0;
            transform: translateX(60px);
            transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.88);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }

        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.35s; }
        .stagger-4 { transition-delay: 0.5s; }
        .stagger-5 { transition-delay: 0.6s; }
        .stagger-6 { transition-delay: 0.7s; }

        /* Hero floating animation */
        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-14px); }
        }
        .hero-float { animation: heroFloat 5s ease-in-out infinite; }
        .hero-float-delay { animation: heroFloat 6s ease-in-out infinite; animation-delay: 1.5s; }

        /* Trust badge strip */
        @keyframes badgeSlideIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .trust-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border-radius: 16px;
            padding: 12px 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            opacity: 0;
            animation: badgeSlideIn 0.6s cubic-bezier(.22,1,.36,1) forwards;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .trust-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .trust-badge:nth-child(1) { animation-delay: 0.3s; }
        .trust-badge:nth-child(2) { animation-delay: 0.5s; }

        /* Pulse dot */
        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.6); }
        }
        .pulse-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #10b981; display: inline-block;
            animation: pulseDot 2s infinite;
        }

        /* Gradient text animation */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-text {
            background: linear-gradient(135deg, #10b981, #059669, #047857, #10b981);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease infinite;
        }

        /* Hover card lift */
        .card-lift {
            position: relative;
            z-index: 0;
            transition: transform 0.4s cubic-bezier(.22,1,.36,1), box-shadow 0.4s ease;
        }
        .card-lift:hover {
            position: relative;
            z-index: 10;
            transform: translateY(-8px) !important;
            box-shadow: 0 25px 60px rgba(0,0,0,0.1) !important;
        }

        /* Image zoom on hover */
        .img-zoom { transition: transform 0.6s cubic-bezier(.22,1,.36,1); }
        .group:hover .img-zoom { transform: scale(1.08); }

        /* Counter section background pattern */
        .stats-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Testimonial card hover glow */
        .testimonial-glow {
            transition: all 0.4s ease;
            position: relative;
        }
        .testimonial-glow::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 24px;
            background: linear-gradient(135deg, transparent, rgba(16,185,129,0.15), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }
        .testimonial-glow:hover::before { opacity: 1; }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* ═══ Premium Button System ═══ */

        /* Primary CTA Button — Emerald gradient with shimmer */
        .btn-cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            background-size: 200% 200%;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.35), inset 0 1px 0 rgba(255,255,255,0.15);
            transition: all 0.4s cubic-bezier(.22,1,.36,1);
            cursor: pointer;
            text-decoration: none;
            letter-spacing: 0.01em;
        }
        .btn-cta-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }
        .btn-cta-primary:hover::before {
            left: 100%;
        }
        .btn-cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 35px rgba(16, 185, 129, 0.5), inset 0 1px 0 rgba(255,255,255,0.2);
            background-position: 100% 0;
        }
        .btn-cta-primary:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-cta-primary .btn-icon {
            transition: transform 0.3s ease;
        }
        .btn-cta-primary:hover .btn-icon {
            transform: translateX(4px);
        }

        /* Secondary / Outline Button */
        .btn-cta-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #059669;
            background: transparent;
            border: 2.5px solid #10b981;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(.22,1,.36,1);
            cursor: pointer;
            text-decoration: none;
            letter-spacing: 0.01em;
        }
        .btn-cta-outline::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #10b981, #059669);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }
        .btn-cta-outline:hover::before {
            opacity: 1;
        }
        .btn-cta-outline:hover {
            color: #fff;
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.35);
        }
        .btn-cta-outline:active {
            transform: translateY(-1px);
        }
        .btn-cta-outline .btn-icon {
            transition: transform 0.3s ease;
        }
        .btn-cta-outline:hover .btn-icon {
            transform: translateX(4px);
        }

        /* Amber CTA Variant */
        .btn-cta-amber {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            background-size: 200% 200%;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.35), inset 0 1px 0 rgba(255,255,255,0.15);
            transition: all 0.4s cubic-bezier(.22,1,.36,1);
            cursor: pointer;
            text-decoration: none;
        }
        .btn-cta-amber::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }
        .btn-cta-amber:hover::before {
            left: 100%;
        }
        .btn-cta-amber:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 35px rgba(245, 158, 11, 0.5), inset 0 1px 0 rgba(255,255,255,0.2);
            background-position: 100% 0;
        }
        .btn-cta-amber:active {
            transform: translateY(-1px);
        }
        .btn-cta-amber .btn-icon {
            transition: transform 0.3s ease;
        }
        .btn-cta-amber:hover .btn-icon {
            transform: translateX(4px);
        }

        /* Amber Outline */
        .btn-cta-amber-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #b45309;
            background: transparent;
            border: 2.5px solid #f59e0b;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(.22,1,.36,1);
            cursor: pointer;
            text-decoration: none;
        }
        .btn-cta-amber-outline::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }
        .btn-cta-amber-outline:hover::before {
            opacity: 1;
        }
        .btn-cta-amber-outline:hover {
            color: #fff;
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.35);
        }
        .btn-cta-amber-outline:active {
            transform: translateY(-1px);
        }
        .btn-cta-amber-outline .btn-icon {
            transition: transform 0.3s ease;
        }
        .btn-cta-amber-outline:hover .btn-icon {
            transform: translateX(4px);
        }

        /* "View all" link button */
        .btn-link-arrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            font-size: 0.9rem;
            color: #059669;
            position: relative;
            padding: 6px 0;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .btn-link-arrow::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 2px;
            transition: width 0.4s cubic-bezier(.22,1,.36,1);
        }
        .btn-link-arrow:hover::after {
            width: 100%;
        }
        .btn-link-arrow:hover {
            color: #047857;
        }
        .btn-link-arrow .btn-icon {
            transition: transform 0.3s ease;
        }
        .btn-link-arrow:hover .btn-icon {
            transform: translateX(5px);
        }

        /* Newsletter Subscribe Button */
        .btn-subscribe {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
            transition: all 0.4s cubic-bezier(.22,1,.36,1);
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-subscribe::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.6s ease;
        }
        .btn-subscribe:hover::before {
            left: 100%;
        }
        .btn-subscribe:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.45);
        }
        .btn-subscribe .btn-icon {
            transition: transform 0.3s ease;
        }
        .btn-subscribe:hover .btn-icon {
            transform: translateX(3px) rotate(-45deg);
        }

        /* Product card "View" action */
        .btn-product-view {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #059669;
            padding: 6px 16px;
            border-radius: 50px;
            background: #ecfdf5;
            border: 1.5px solid transparent;
            transition: all 0.3s ease;
        }
        .btn-product-view .btn-icon {
            transition: transform 0.3s ease;
        }
        .group:hover .btn-product-view {
            background: #059669;
            color: #fff;
            border-color: #059669;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }
        .group:hover .btn-product-view .btn-icon {
            transform: translateX(3px);
        }
    </style>

    {{-- ══════════════════════════════════════════════════════════════
         HERO SECTION — with floating cards, animated stats, badge
    ══════════════════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(16,185,129,0.12),_transparent_55%)]"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-amber-200/20 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-10 left-10 w-56 h-56 bg-emerald-200/20 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] items-center">
                <div>
                    <div class="reveal">
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-100 px-4 py-2 text-xs font-semibold text-emerald-700 uppercase tracking-widest">
                            <span class="pulse-dot"></span>
                            Farm-to-kitchen spices
                        </span>
                    </div>
                    <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-semibold text-stone-900 leading-tight reveal stagger-1">
                        Fresh spices sourced directly from
                        <span class="gradient-text">trusted farmers.</span>
                    </h1>
                    <p class="mt-5 text-stone-600 text-lg reveal stagger-2">Discover single-origin turmeric, pepper, cardamom, and more. We keep it transparent, traceable, and flavorful from harvest to your kitchen.</p>
                    <div class="mt-8 flex flex-wrap gap-4 reveal stagger-3">
                        <a href="{{ route('products.index') }}" class="btn-cta-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Shop spices
                            <svg class="w-4 h-4 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#categories" class="btn-cta-outline">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Browse categories
                            <svg class="w-4 h-4 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                    </div>
                    <div class="mt-12 grid grid-cols-1 gap-4 text-sm text-stone-600 sm:grid-cols-3 sm:gap-6 reveal stagger-4">
                        <div class="bg-white/70 rounded-2xl p-4 border border-stone-100">
                            <p class="text-3xl font-semibold text-stone-900" data-count="120">0</p>
                            <p class="mt-1 text-stone-500">Farmer partners</p>
                        </div>
                        <div class="bg-white/70 rounded-2xl p-4 border border-stone-100">
                            <p class="text-3xl font-semibold text-stone-900">36 hrs</p>
                            <p class="mt-1 text-stone-500">Roast to pack</p>
                        </div>
                        <div class="bg-white/70 rounded-2xl p-4 border border-stone-100">
                            <p class="text-3xl font-semibold text-stone-900">4.9/5</p>
                            <p class="mt-1 text-stone-500">Customer ratings</p>
                        </div>
                    </div>
                </div>

                {{-- Hero images with floating badges --}}
                <div class="relative reveal-right stagger-2">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="relative overflow-hidden rounded-3xl shadow-lg hero-float group">
                            <img src="{{ asset('images/turmeric.png') }}" alt="Spices in bowls" class="h-64 w-full object-cover img-zoom" />
                            <div class="absolute inset-0 bg-gradient-to-t from-stone-900/60 via-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <p class="text-sm uppercase tracking-[0.25em]">Signature</p>
                                <p class="text-lg font-semibold">Golden Turmeric</p>
                            </div>
                        </div>
                        <div class="relative overflow-hidden rounded-3xl shadow-lg hero-float-delay group">
                            <img src="{{ asset('images/black_pepper.png') }}" alt="Whole spices" class="h-64 w-full object-cover img-zoom" />
                            <div class="absolute inset-0 bg-gradient-to-t from-stone-900/60 via-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <p class="text-sm uppercase tracking-[0.25em]">Fresh</p>
                                <p class="text-lg font-semibold">Black Pepper</p>
                            </div>
                        </div>
                    </div>

                    {{-- Trust badges (inline, no overlap) --}}
                    <div class="flex flex-wrap gap-3 mt-4">
                        <div class="trust-badge">
                            <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 shrink-0">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Quality Certified</p>
                                <p class="text-sm font-bold text-stone-900 leading-tight">100% Organic</p>
                            </div>
                        </div>
                        <div class="trust-badge">
                            <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 shrink-0 text-sm">⭐</div>
                            <div>
                                <p class="text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Customer Love</p>
                                <p class="text-sm font-bold text-stone-900 leading-tight">12K+ Happy</p>
                            </div>
                        </div>
                    </div>

                    {{-- Feature pills --}}
                    <div class="rounded-3xl bg-white p-5 shadow-lg sm:col-span-2 mt-4 reveal stagger-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-emerald-50 p-4 card-lift cursor-default">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Direct sourcing</p>
                                <p class="mt-2 text-stone-600 text-sm">Farmer-first partnerships, fair prices.</p>
                            </div>
                            <div class="rounded-2xl bg-amber-50 p-4 card-lift cursor-default">
                                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-semibold">Quality checks</p>
                                <p class="mt-2 text-stone-600 text-sm">Small batches, sealed freshness.</p>
                            </div>
                            <div class="rounded-2xl bg-rose-50 p-4 card-lift cursor-default">
                                <p class="text-xs uppercase tracking-[0.2em] text-rose-700 font-semibold">Traceable origin</p>
                                <p class="mt-2 text-stone-600 text-sm">Know the farm and harvest.</p>
                            </div>
                            <div class="rounded-2xl bg-sky-50 p-4 card-lift cursor-default">
                                <p class="text-xs uppercase tracking-[0.2em] text-sky-700 font-semibold">Fast shipping</p>
                                <p class="mt-2 text-stone-600 text-sm">Packed fresh, delivered quickly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         FEATURED SPICES
    ══════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24">
        <div class="flex flex-wrap items-end justify-between gap-3 reveal">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-bold mb-2">Handpicked for you</p>
                <h2 class="text-3xl font-semibold text-stone-900">Featured spices</h2>
            </div>
            <a class="btn-link-arrow" href="{{ route('products.index') }}">
                View all
                <svg class="w-4 h-4 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 pb-4">
            @forelse($featured as $product)
                @php
                    $fallbackImages = [
                        asset('images/turmeric.png'),
                        asset('images/black_pepper.png'),
                        asset('images/cloves.png'),
                    ];
                    $cardImage = $product->image_url;
                    if ($cardImage) {
                        if (\Illuminate\Support\Str::startsWith($cardImage, ['http://', 'https://'])) {
                            $cardImage = $cardImage;
                        } elseif (\Illuminate\Support\Str::startsWith($cardImage, ['storage/', 'images/'])) {
                            $cardImage = asset($cardImage);
                        } else {
                            $cardImage = asset('storage/' . $cardImage);
                        }
                    } else {
                        $cardImage = $fallbackImages[$loop->index % count($fallbackImages)];
                    }
                @endphp
                <a href="{{ route('products.show', $product->slug) }}"
                   class="group block rounded-3xl border border-stone-100 bg-white p-5 shadow-sm card-lift reveal-scale stagger-{{ ($loop->index % 3) + 1 }}">
                    <div class="relative overflow-hidden rounded-2xl">
                        <img src="{{ $cardImage }}" alt="{{ $product->name }}" class="h-48 w-full object-cover img-zoom" />
                        <div class="absolute top-4 left-4 rounded-full bg-white/90 backdrop-blur px-3 py-1 text-xs font-semibold text-stone-700">{{ $product->origin ?? 'Single origin' }}</div>
                    </div>
                    <h3 class="mt-4 font-semibold text-lg group-hover:text-emerald-700 transition-colors">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-stone-600">{{ $product->unit }}</p>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <span class="font-bold text-lg text-stone-900">
                            INR {{ number_format($product->displayPrice(), 2) }}
                            @if($product->hasActiveOffer())
                                <span class="ml-2 text-xs font-normal text-stone-400 line-through">INR {{ number_format((float) $product->price, 2) }}</span>
                            @endif
                        </span>
                        <span class="btn-product-view">
                            View
                            <svg class="w-3.5 h-3.5 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
            @empty
                <p class="text-stone-600 reveal">No featured spices yet. Add some in the admin panel.</p>
            @endforelse
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         LATEST OFFERS
    ══════════════════════════════════════════════════════════════ --}}
    <section class="bg-white/70 border-y border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="flex flex-wrap items-end justify-between gap-3 reveal">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-rose-700 font-bold mb-2">Flash deals</p>
                    <h2 class="text-3xl font-semibold text-stone-900">Latest offers</h2>
                </div>
                <a class="btn-link-arrow" href="{{ route('offers.index') }}">
                    See all offers
                    <svg class="w-4 h-4 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4 pb-4">
                @forelse($offerProducts as $product)
                    @php
                        $offerImage = $product->image_url;
                        if ($offerImage) {
                            if (\Illuminate\Support\Str::startsWith($offerImage, ['http://', 'https://'])) {
                                $offerImage = $offerImage;
                            } elseif (\Illuminate\Support\Str::startsWith($offerImage, ['storage/', 'images/'])) {
                                $offerImage = asset($offerImage);
                            } else {
                                $offerImage = asset('storage/' . $offerImage);
                            }
                        } else {
                            $offerImage = asset('images/turmeric.png');
                        }
                    @endphp
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="group rounded-3xl border border-stone-100 bg-white p-4 shadow-sm card-lift reveal stagger-{{ $loop->index + 1 }}">
                        <div class="relative overflow-hidden rounded-2xl">
                            <img src="{{ $offerImage }}" alt="{{ $product->name }}" class="h-40 w-full object-cover img-zoom" />
                            <span class="absolute left-3 top-3 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                {{ $product->activeOfferLabel() ?? 'Hot deal' }}
                            </span>
                        </div>
                        <p class="mt-4 font-semibold group-hover:text-emerald-700 transition-colors">{{ $product->name }}</p>
                        <p class="mt-1 text-sm text-stone-600">{{ $product->unit }}</p>
                        <p class="mt-2 font-semibold text-lg">
                            INR {{ number_format($product->displayPrice(), 2) }}
                            @if($product->hasActiveOffer())
                                <span class="ml-2 text-xs font-normal text-stone-400 line-through">INR {{ number_format((float) $product->price, 2) }}</span>
                            @endif
                        </p>
                    </a>
                @empty
                    <p class="text-stone-600 reveal">No active offers right now.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         STATS / TRUST BANNER with counter animation
    ══════════════════════════════════════════════════════════════ --}}
    <section class="bg-stone-900 text-white stats-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center reveal">
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-400 font-bold mb-3">Trusted by thousands</p>
                <h2 class="text-3xl sm:text-4xl font-semibold">Rooted in <span class="text-emerald-400">Tradition</span>, Driven by Quality</h2>
                <p class="mt-4 text-stone-400 max-w-xl mx-auto">For over a decade, we've partnered with small-hold farmers across Kerala to bring you spices that are authentic, sustainable, and bursting with flavor.</p>
            </div>
            <div class="mt-14 grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center reveal stagger-1">
                    <p class="text-4xl sm:text-5xl font-bold text-emerald-400" data-count="200">0</p>
                    <p class="mt-2 text-stone-400 text-sm">Partner Farmers</p>
                </div>
                <div class="text-center reveal stagger-2">
                    <p class="text-4xl sm:text-5xl font-bold text-emerald-400" data-count="12000">0</p>
                    <p class="mt-2 text-stone-400 text-sm">Happy Customers</p>
                </div>
                <div class="text-center reveal stagger-3">
                    <p class="text-4xl sm:text-5xl font-bold text-emerald-400" data-count="50">0</p>
                    <p class="mt-2 text-stone-400 text-sm">Spice Varieties</p>
                </div>
                <div class="text-center reveal stagger-4">
                    <p class="text-4xl sm:text-5xl font-bold text-amber-400" data-count="100">0</p>
                    <p class="mt-2 text-stone-400 text-sm">% Organic</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         GIFT BOXES
    ══════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid gap-10 lg:grid-cols-[1fr_1.2fr] items-center">
            <div class="reveal-left">
                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-bold mb-2">Gift hampers</p>
                <h2 class="text-2xl sm:text-3xl font-semibold">Gift boxes for festivals, weddings, and corporate events</h2>
                <p class="mt-4 text-stone-600">
                    Choose curated spice collections in premium packaging. We can help with bulk orders, personalized packs, and event-ready delivery.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('gift-boxes.index') }}" class="btn-cta-amber">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                        Explore gift boxes
                        <svg class="w-4 h-4 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('corporate-gifts.index') }}" class="btn-cta-amber-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Corporate gifting
                        <svg class="w-4 h-4 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 pb-2">
                @forelse($giftBoxProducts as $product)
                    @php
                        $giftImage = $product->image_url;
                        if ($giftImage) {
                            if (\Illuminate\Support\Str::startsWith($giftImage, ['http://', 'https://'])) {
                                $giftImage = $giftImage;
                            } elseif (\Illuminate\Support\Str::startsWith($giftImage, ['storage/', 'images/'])) {
                                $giftImage = asset($giftImage);
                            } else {
                                $giftImage = asset('storage/' . $giftImage);
                            }
                        } else {
                            $giftImage = asset('images/cloves.png');
                        }
                    @endphp
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="group rounded-3xl border border-stone-100 bg-white p-4 shadow-sm card-lift reveal-scale stagger-{{ $loop->index + 1 }}">
                        <div class="relative overflow-hidden rounded-2xl">
                            <img src="{{ $giftImage }}" alt="{{ $product->name }}" class="h-40 w-full object-cover img-zoom" />
                        </div>
                        <p class="mt-4 font-semibold group-hover:text-amber-700 transition-colors">{{ $product->name }}</p>
                        <p class="mt-2 text-sm text-stone-600">{{ $product->category?->name ?? 'Gift Collection' }}</p>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-stone-300 p-6 bg-white/80 sm:col-span-2 reveal">
                        <p class="text-stone-600">Gift boxes will appear here once products are added in relevant categories.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         CATEGORIES
    ══════════════════════════════════════════════════════════════ --}}
    <section id="categories" class="bg-white/70 border-t border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="reveal">
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-bold mb-2">Browse collection</p>
                <h2 class="text-3xl font-semibold text-stone-900">Shop by category</h2>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4 pb-4">
                @forelse($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="group rounded-3xl border border-stone-100 bg-white p-5 shadow-sm card-lift reveal stagger-{{ ($loop->index % 4) + 1 }}">
                        <div class="h-24 rounded-2xl bg-emerald-50/70 flex items-center justify-center text-3xl font-semibold text-emerald-700 group-hover:bg-emerald-100 group-hover:scale-105 transition-all duration-300">
                            {{ strtoupper(substr($category->name, 0, 1)) }}
                        </div>
                        <p class="mt-4 font-semibold group-hover:text-emerald-700 transition-colors">{{ $category->name }}</p>
                        <p class="mt-2 text-sm text-stone-600">{{ $category->products_count }} items</p>
                    </a>
                @empty
                    <p class="text-stone-600 reveal">No categories yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         TESTIMONIALS
    ══════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center reveal">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-bold mb-2">Customer love</p>
            <h2 class="text-3xl font-semibold text-stone-900">What our customers say</h2>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-3 pb-2">
            <div class="rounded-3xl border border-stone-100 bg-white p-7 testimonial-glow reveal stagger-1">
                <div class="text-amber-400 text-lg mb-4 tracking-wider">★★★★★</div>
                <p class="text-stone-600 leading-relaxed italic">"The cloves from Spice Basket have an aroma unlike anything I've found in stores. You can tell they're fresh and hand-sorted. Absolutely worth every rupee!"</p>
                <div class="mt-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold">P</div>
                    <div>
                        <p class="font-semibold text-sm text-stone-900">Priya Menon</p>
                        <p class="text-xs text-stone-500">Kochi, Kerala</p>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl border border-stone-100 bg-white p-7 testimonial-glow reveal stagger-2">
                <div class="text-amber-400 text-lg mb-4 tracking-wider">★★★★★</div>
                <p class="text-stone-600 leading-relaxed italic">"As a professional chef, I need the best ingredients. Their black pepper has an incredible bite and warmth that elevates every dish I prepare."</p>
                <div class="mt-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-bold">R</div>
                    <div>
                        <p class="font-semibold text-sm text-stone-900">Chef Rahul Sharma</p>
                        <p class="text-xs text-stone-500">Mumbai, Maharashtra</p>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl border border-stone-100 bg-white p-7 testimonial-glow reveal stagger-3">
                <div class="text-amber-400 text-lg mb-4 tracking-wider">★★★★★</div>
                <p class="text-stone-600 leading-relaxed italic">"Fast delivery, beautiful packaging, and the turmeric is genuinely golden — you can see the curcumin richness. This is my go-to spice store now."</p>
                <div class="mt-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white font-bold">A</div>
                    <div>
                        <p class="font-semibold text-sm text-stone-900">Anita Desai</p>
                        <p class="text-xs text-stone-500">Bengaluru, Karnataka</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         NEWSLETTER CTA
    ══════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="rounded-3xl bg-gradient-to-br from-emerald-50 via-white to-amber-50 border border-stone-100 p-10 sm:p-16 text-center reveal-scale">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-bold mb-3">Stay updated</p>
            <h2 class="text-2xl sm:text-3xl font-semibold text-stone-900">Get fresh spice drops<br>in your inbox</h2>
            <p class="mt-4 text-stone-500 max-w-md mx-auto">Join 8,000+ spice lovers. Receive recipes, seasonal offers, and first access to new arrivals.</p>
            <form class="mt-8 flex flex-col sm:flex-row gap-3 max-w-lg mx-auto" onsubmit="event.preventDefault();">
                <input type="email" class="flex-1 rounded-full border-2 border-stone-200 px-6 py-3.5 text-sm focus:border-emerald-400 focus:ring-0 outline-none transition-all duration-300 focus:shadow-[0_0_0_4px_rgba(16,185,129,0.1)]" placeholder="Your email address" required>
                <button type="submit" class="btn-subscribe">
                    Subscribe
                    <svg class="w-4 h-4 btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         WHY CHOOSE US — bottom info cards
    ══════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-24">
        <div class="grid gap-8 lg:grid-cols-3 pb-2">
            <div class="rounded-3xl border border-stone-100 bg-white p-7 card-lift reveal stagger-1">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-700 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Authentic sourcing</p>
                <h3 class="mt-3 text-xl font-semibold">Direct from partner farmers</h3>
                <p class="mt-3 text-sm text-stone-600">Transparent sourcing and fair partnerships help us maintain quality at every batch.</p>
            </div>
            <div class="rounded-3xl border border-stone-100 bg-white p-7 card-lift reveal stagger-2">
                <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-700 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <p class="text-xs uppercase tracking-[0.2em] text-sky-700 font-semibold">Customer support</p>
                <h3 class="mt-3 text-xl font-semibold">Fast response and order assistance</h3>
                <p class="mt-3 text-sm text-stone-600">Need product help, bulk packing, or order updates? We respond quickly and stay accountable.</p>
            </div>
            <div class="rounded-3xl border border-stone-100 bg-white p-7 card-lift reveal stagger-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-700 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-semibold">Trusted by customers</p>
                <h3 class="mt-3 text-xl font-semibold">Consistent quality and repeat orders</h3>
                <p class="mt-3 text-sm text-stone-600">Thousands of repeat customers rely on our freshness, aroma, and reliable packing quality.</p>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         SCROLL ANIMATION & COUNTER SCRIPT
    ══════════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ── IntersectionObserver for scroll reveal ──
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
                revealObserver.observe(el);
            });

            // ── Counter animation ──
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = parseInt(el.getAttribute('data-count'));
                        const duration = 2200;
                        const start = performance.now();

                        function update(now) {
                            const elapsed = now - start;
                            const progress = Math.min(elapsed / duration, 1);
                            const eased = 1 - Math.pow(1 - progress, 3);
                            const current = Math.floor(eased * target);

                            if (target >= 1000) {
                                el.textContent = (current / 1000).toFixed(current >= target ? 0 : 1) + 'K+';
                            } else {
                                el.textContent = current + '+';
                            }

                            if (progress < 1) {
                                requestAnimationFrame(update);
                            } else {
                                el.textContent = target >= 1000
                                    ? (target / 1000) + 'K+'
                                    : target + '+';
                            }
                        }
                        requestAnimationFrame(update);
                        counterObserver.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });

            document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));

            // ── Smooth scroll for anchor links ──
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        });
    </script>

</x-shop-layout>
