<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Spice Basket') }} — Premium Kerala Spices</title>
    <meta name="description" content="Discover the finest hand-picked spices from the hills of Kerala. Farm-fresh, organic, and delivered to your doorstep.">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --orange: #F05423;
            --orange-dark: #D94415;
            --orange-light: #FFF5F0;
            --gold: #C9933C;
            --dark: #1A1A1A;
            --gray-50: #FAFAFA;
            --gray-100: #F4F4F5;
            --gray-300: #D1D5DB;
            --gray-500: #6B7280;
            --gray-700: #374151;
            --white: #FFFFFF;
            --radius: 16px;
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: var(--gray-50);
            overflow-x: hidden;
        }
        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; }
        a { text-decoration: none; color: inherit; }
        img { display: block; max-width: 100%; }
        button { cursor: pointer; border: none; font-family: inherit; }

        /* ── Scroll Animation Classes ── */
        .reveal {
            opacity: 0;
            transform: translateY(60px);
            transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-80px);
            transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }
        .reveal-right {
            opacity: 0;
            transform: translateX(80px);
            transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }
        .reveal-scale {
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.25s; }
        .stagger-3 { transition-delay: 0.4s; }
        .stagger-4 { transition-delay: 0.55s; }

        /* ── Navbar ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0,0,0,.06);
            transition: box-shadow .3s, background .3s;
        }
        .navbar.scrolled { box-shadow: 0 4px 30px rgba(0,0,0,.08); background: rgba(255,255,255,0.95); }
        .nav-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 16px 32px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-brand { display: flex; align-items: center; gap: 10px; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.4rem; }
        .nav-brand .dot { width: 10px; height: 10px; border-radius: 50%; background: var(--orange); }
        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-links a { font-size: 0.9rem; font-weight: 600; color: var(--gray-700); transition: color .3s; }
        .nav-links a:hover { color: var(--orange); }
        .nav-cta {
            background: var(--orange); color: #fff; padding: 10px 28px;
            border-radius: 50px; font-weight: 700; font-size: 0.85rem;
            transition: transform .3s, box-shadow .3s;
            box-shadow: 0 4px 20px rgba(240,84,35,.3);
        }
        .nav-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(240,84,35,.45); }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center;
            padding: 120px 32px 80px;
            background: linear-gradient(135deg, #FFF5F0 0%, #FFF9F5 40%, #F9F9F9 100%);
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -200px; right: -200px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(240,84,35,.08) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }
        .hero::after {
            content: ''; position: absolute; bottom: -100px; left: -100px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(201,147,60,.06) 0%, transparent 70%);
            animation: float 10s ease-in-out infinite reverse;
        }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        .hero-inner { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; position: relative; z-index: 1; width: 100%; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(240,84,35,.08); border: 1px solid rgba(240,84,35,.15);
            padding: 8px 18px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;
            color: var(--orange); margin-bottom: 24px;
        }
        .hero-badge .pulse { width: 8px; height: 8px; border-radius: 50%; background: var(--orange); animation: pulse-dot 2s infinite; }
        @keyframes pulse-dot { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: .5; transform: scale(1.5); } }
        .hero h1 { font-size: 4rem; font-weight: 800; line-height: 1.1; margin-bottom: 24px; letter-spacing: -1px; }
        .hero h1 span { color: var(--orange); position: relative; }
        .hero h1 span::after {
            content: ''; position: absolute; bottom: 4px; left: 0; right: 0;
            height: 12px; background: rgba(240,84,35,.12); border-radius: 4px; z-index: -1;
        }
        .hero-desc { font-size: 1.15rem; color: var(--gray-500); line-height: 1.7; margin-bottom: 40px; max-width: 480px; }
        .hero-actions { display: flex; gap: 16px; align-items: center; }
        .btn-primary {
            background: var(--orange); color: #fff; padding: 16px 36px;
            border-radius: 50px; font-weight: 700; font-size: 0.95rem;
            box-shadow: 0 6px 30px rgba(240,84,35,.35);
            transition: all .3s;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 40px rgba(240,84,35,.5); }
        .btn-outline {
            background: transparent; color: var(--dark); padding: 16px 36px;
            border-radius: 50px; font-weight: 700; font-size: 0.95rem;
            border: 2px solid var(--gray-300); transition: all .3s;
        }
        .btn-outline:hover { border-color: var(--orange); color: var(--orange); }
        .hero-image { position: relative; }
        .hero-image-main {
            border-radius: 30px; overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,.12);
            animation: heroFloat 6s ease-in-out infinite;
        }
        @keyframes heroFloat { 0%,100%{ transform: translateY(0) rotate(0); } 50%{ transform: translateY(-15px) rotate(1deg); } }
        .hero-float-card {
            position: absolute; background: #fff; border-radius: 16px; padding: 16px 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,.1);
            animation: floatCard 5s ease-in-out infinite;
        }
        @keyframes floatCard { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-12px); } }
        .hero-float-card.card-one { bottom: 30px; left: -30px; animation-delay: 0.5s; }
        .hero-float-card.card-two { top: 30px; right: -20px; animation-delay: 1s; }
        .float-card-label { font-size: 0.7rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .float-card-value { font-size: 1.4rem; font-weight: 800; color: var(--dark); font-family: 'Playfair Display', serif; }

        /* ── Section Styles ── */
        .section { padding: 100px 32px; max-width: 1280px; margin: 0 auto; }
        .section-label {
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 3px; color: var(--orange); margin-bottom: 12px;
        }
        .section-title { font-size: 2.8rem; font-weight: 700; margin-bottom: 20px; line-height: 1.2; }
        .section-desc { font-size: 1.05rem; color: var(--gray-500); max-width: 520px; line-height: 1.7; }

        /* ── Categories ── */
        .categories-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-top: 60px; }
        .cat-card {
            background: #fff; border-radius: 24px; padding: 40px 28px; text-align: center;
            border: 1px solid rgba(0,0,0,.04);
            transition: all .4s cubic-bezier(.22,1,.36,1);
            position: relative;
            z-index: 0;
            overflow: hidden;
        }
        .cat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--orange), var(--gold));
            transform: scaleX(0); transition: transform .4s; transform-origin: left;
        }
        .cat-card:hover::before { transform: scaleX(1); }
        .cat-card:hover {
            position: relative;
            z-index: 10;
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0,0,0,.08);
        }
        .cat-icon {
            width: 72px; height: 72px; border-radius: 20px; margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center; font-size: 2rem;
            background: var(--orange-light); transition: background .3s, transform .3s;
        }
        .cat-card:hover .cat-icon { background: var(--orange); transform: scale(1.1) rotate(-5deg); }
        .cat-card:hover .cat-icon span { filter: brightness(10); }
        .cat-name { font-family: 'Playfair Display', serif; font-weight: 600; font-size: 1.1rem; margin-bottom: 6px; }
        .cat-count { font-size: 0.8rem; color: var(--gray-500); }

        /* ── Products ── */
        .products-section { background: var(--white); }
        .products-inner { max-width: 1280px; margin: 0 auto; padding: 100px 32px; }
        .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; margin-top: 60px; }
        .product-card {
            background: var(--gray-50); border-radius: 24px; overflow: hidden;
            transition: all .4s cubic-bezier(.22,1,.36,1);
            position: relative;
            z-index: 0;
        }
        .product-card:hover {
            position: relative;
            z-index: 10;
            transform: translateY(-10px);
            box-shadow: 0 30px 80px rgba(0,0,0,.1);
        }
        .product-img { position: relative; height: 240px; overflow: hidden; background: #f0f0f0; }
        .product-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s cubic-bezier(.22,1,.36,1); }
        .product-card:hover .product-img img { transform: scale(1.08); }
        .product-tag {
            position: absolute; top: 16px; left: 16px;
            background: var(--orange); color: #fff; font-size: 0.7rem; font-weight: 700;
            padding: 5px 14px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .product-body { padding: 24px; }
        .product-origin { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--gold); margin-bottom: 8px; }
        .product-name { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; margin-bottom: 6px; }
        .product-sub { font-size: 0.82rem; color: var(--gray-500); margin-bottom: 16px; font-style: italic; }
        .product-footer { display: flex; align-items: center; justify-content: space-between; }
        .product-price { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--orange); }
        .product-cart-btn {
            width: 44px; height: 44px; border-radius: 50%; background: var(--orange); color: #fff;
            display: flex; align-items: center; justify-content: center;
            transition: all .3s; box-shadow: 0 4px 15px rgba(240,84,35,.3);
        }
        .product-cart-btn:hover { transform: scale(1.15) rotate(-10deg); }

        /* ── Parallax Banner ── */
        .parallax-banner {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d1810 100%);
            color: #fff; padding: 120px 32px; text-align: center;
            position: relative; overflow: hidden;
        }
        .parallax-banner::before {
            content: ''; position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .parallax-inner { position: relative; z-index: 1; max-width: 800px; margin: 0 auto; }
        .parallax-banner h2 { font-size: 3rem; font-weight: 700; margin-bottom: 20px; }
        .parallax-banner h2 span { color: var(--orange); }
        .parallax-banner p { font-size: 1.1rem; color: rgba(255,255,255,.6); margin-bottom: 40px; line-height: 1.7; }

        /* ── Stats ── */
        .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; margin-top: 60px; }
        .stat-item { text-align: center; }
        .stat-number { font-family: 'Playfair Display', serif; font-size: 2.8rem; font-weight: 800; color: var(--orange); }
        .stat-label { font-size: 0.85rem; color: rgba(255,255,255,.5); margin-top: 4px; font-weight: 500; }

        /* ── Testimonials ── */
        .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-top: 60px; }
        .testimonial-card {
            background: #fff; padding: 36px; border-radius: 24px;
            border: 1px solid rgba(0,0,0,.04);
            transition: all .4s;
            position: relative;
            z-index: 0;
        }
        .testimonial-card:hover {
            position: relative;
            z-index: 10;
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,.08);
        }
        .testimonial-stars { color: #F59E0B; font-size: 1rem; margin-bottom: 16px; letter-spacing: 2px; }
        .testimonial-text { font-size: 0.95rem; color: var(--gray-700); line-height: 1.7; margin-bottom: 20px; font-style: italic; }
        .testimonial-author { display: flex; align-items: center; gap: 12px; }
        .testimonial-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--orange), var(--gold));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 1rem;
        }
        .testimonial-name { font-weight: 700; font-size: 0.9rem; }
        .testimonial-location { font-size: 0.75rem; color: var(--gray-500); }

        /* ── Newsletter ── */
        .newsletter {
            background: linear-gradient(135deg, var(--orange-light), #FFF9F5);
            border-radius: 32px; padding: 80px; text-align: center;
            margin: 0 32px; max-width: 1216px; margin-left: auto; margin-right: auto;
            position: relative; overflow: hidden;
        }
        .newsletter::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(240,84,35,.08);
        }
        .newsletter-form { display: flex; gap: 12px; max-width: 480px; margin: 30px auto 0; }
        .newsletter-input {
            flex: 1; padding: 16px 24px; border-radius: 50px;
            border: 2px solid rgba(0,0,0,.08); font-size: 0.9rem; font-family: inherit;
            outline: none; transition: border-color .3s;
        }
        .newsletter-input:focus { border-color: var(--orange); }

        /* ── Footer ── */
        .footer { background: #111; color: #fff; padding: 80px 32px 32px; }
        .footer-inner { max-width: 1280px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 60px; }
        .footer-brand-desc { color: rgba(255,255,255,.4); font-size: 0.9rem; line-height: 1.7; margin-top: 16px; }
        .footer-heading { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,.3); margin-bottom: 20px; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: rgba(255,255,255,.6); font-size: 0.9rem; transition: color .3s; }
        .footer-links a:hover { color: var(--orange); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding-top: 24px; text-align: center; color: rgba(255,255,255,.25); font-size: 0.8rem; }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .hero-inner { grid-template-columns: 1fr; text-align: center; }
            .hero h1 { font-size: 3rem; }
            .hero-desc { margin: 0 auto 40px; }
            .hero-actions { justify-content: center; }
            .hero-image { display: none; }
            .categories-grid, .products-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-strip { grid-template-columns: repeat(2, 1fr); }
            .testimonials-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .hero h1 { font-size: 2.2rem; }
            .section-title { font-size: 2rem; }
            .categories-grid, .products-grid { grid-template-columns: 1fr; }
            .stats-strip { grid-template-columns: 1fr 1fr; }
            .nav-links { display: none; }
            .newsletter { padding: 40px 24px; margin: 0 16px; }
            .newsletter-form { flex-direction: column; }
            .hero-actions { flex-direction: column; }
        }
    </style>
</head>
<body>

    <!-- ══ Navbar ══ -->
    <nav class="navbar" id="navbar">
        <div class="nav-inner">
            <a href="#" class="nav-brand">
                <span class="dot"></span> Spice Basket
            </a>
            <div class="nav-links">
                <a href="#categories">Categories</a>
                <a href="#products">Shop</a>
                <a href="#testimonials">Reviews</a>
                <a href="#newsletter">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-cta">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-cta">Sign In</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ══ Hero ══ -->
    <section class="hero" id="hero">
        <div class="hero-inner">
            <div>
                <div class="hero-badge reveal">
                    <span class="pulse"></span>
                    Farm-Fresh from Kerala
                </div>
                <h1 class="reveal stagger-1">Flavors that tell <span>a story</span></h1>
                <p class="hero-desc reveal stagger-2">Experience the richness of hand-picked, sun-dried spices sourced directly from the lush plantations of Kerala's Western Ghats.</p>
                <div class="hero-actions reveal stagger-3">
                    <a href="#products" class="btn-primary">Explore Collection</a>
                    <a href="#story" class="btn-outline">Our Story</a>
                </div>
            </div>
            <div class="hero-image reveal-right stagger-2">
                <div class="hero-image-main">
                    <img src="{{ asset('images/turmeric.png') }}" alt="Premium Kerala Spices" style="width:100%;height:450px;object-fit:cover;">
                </div>
                <div class="hero-float-card card-one">
                    <div class="float-card-label">Happy Customers</div>
                    <div class="float-card-value">12K+</div>
                </div>
                <div class="hero-float-card card-two">
                    <div class="float-card-label">Organic Certified</div>
                    <div class="float-card-value">100%</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══ Categories ══ -->
    <section class="section" id="categories">
        <div class="reveal">
            <p class="section-label">Browse by Category</p>
            <h2 class="section-title">Curated Spice Collections</h2>
            <p class="section-desc">From whole spices to artisan blends — find exactly what your kitchen needs.</p>
        </div>
        <div class="categories-grid">
            <div class="cat-card reveal stagger-1">
                <div class="cat-icon"><span>🌶️</span></div>
                <div class="cat-name">Whole Spices</div>
                <div class="cat-count">24 Products</div>
            </div>
            <div class="cat-card reveal stagger-2">
                <div class="cat-icon"><span>🫚</span></div>
                <div class="cat-name">Ground Powders</div>
                <div class="cat-count">18 Products</div>
            </div>
            <div class="cat-card reveal stagger-3">
                <div class="cat-icon"><span>🧂</span></div>
                <div class="cat-name">Spice Blends</div>
                <div class="cat-count">12 Products</div>
            </div>
            <div class="cat-card reveal stagger-4">
                <div class="cat-icon"><span>🍯</span></div>
                <div class="cat-name">Oils & Extracts</div>
                <div class="cat-count">9 Products</div>
            </div>
        </div>
    </section>

    <!-- ══ Featured Products ══ -->
    <section class="products-section" id="products">
        <div class="products-inner">
            <div class="reveal">
                <p class="section-label">Handpicked for You</p>
                <h2 class="section-title">Bestselling Spices</h2>
                <p class="section-desc">The finest spices from Kerala's spice gardens — loved by chefs and home cooks alike.</p>
            </div>
            <div class="products-grid">
                <div class="product-card reveal-scale stagger-1">
                    <div class="product-img">
                        <img src="{{ asset('images/cloves.png') }}" alt="Idukki Cloves">
                        <span class="product-tag">Bestseller</span>
                    </div>
                    <div class="product-body">
                        <div class="product-origin">Idukki, Kerala</div>
                        <div class="product-name">Premium Cloves</div>
                        <div class="product-sub">Sun-dried and hand-picked</div>
                        <div class="product-footer">
                            <span class="product-price">₹320</span>
                            <button class="product-cart-btn" aria-label="Add to cart">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="product-card reveal-scale stagger-2">
                    <div class="product-img">
                        <img src="{{ asset('images/black_pepper.png') }}" alt="Black Pepper">
                        <span class="product-tag">Popular</span>
                    </div>
                    <div class="product-body">
                        <div class="product-origin">Wayanad, Kerala</div>
                        <div class="product-name">Black Pepper</div>
                        <div class="product-sub">Pungent and aromatic</div>
                        <div class="product-footer">
                            <span class="product-price">₹250</span>
                            <button class="product-cart-btn" aria-label="Add to cart">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="product-card reveal-scale stagger-3">
                    <div class="product-img">
                        <img src="{{ asset('images/turmeric.png') }}" alt="Turmeric">
                        <span class="product-tag">Organic</span>
                    </div>
                    <div class="product-body">
                        <div class="product-origin">Alleppey, Kerala</div>
                        <div class="product-name">Alleppey Turmeric</div>
                        <div class="product-sub">High curcumin content</div>
                        <div class="product-footer">
                            <span class="product-price">₹180</span>
                            <button class="product-cart-btn" aria-label="Add to cart">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="product-card reveal-scale stagger-4">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1631553384214-724d2713f01b?q=80&w=600&auto=format&fit=crop" alt="Green Cardamom">
                        <span class="product-tag" style="background:var(--gold)">Premium</span>
                    </div>
                    <div class="product-body">
                        <div class="product-origin">Munnar, Kerala</div>
                        <div class="product-name">Green Cardamom</div>
                        <div class="product-sub">Grade A premium quality</div>
                        <div class="product-footer">
                            <span class="product-price">₹450</span>
                            <button class="product-cart-btn" aria-label="Add to cart">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══ Parallax Stats Banner ══ -->
    <section class="parallax-banner" id="story">
        <div class="parallax-inner">
            <div class="reveal">
                <h2>Rooted in <span>Tradition</span>, Driven by Quality</h2>
                <p>For over a decade, we've partnered with 200+ small-hold farmers across Kerala to bring you spices that are authentic, sustainable, and bursting with flavor.</p>
            </div>
            <div class="stats-strip">
                <div class="stat-item reveal stagger-1">
                    <div class="stat-number" data-count="200">0</div>
                    <div class="stat-label">Partner Farmers</div>
                </div>
                <div class="stat-item reveal stagger-2">
                    <div class="stat-number" data-count="12000">0</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="stat-item reveal stagger-3">
                    <div class="stat-number" data-count="50">0</div>
                    <div class="stat-label">Spice Varieties</div>
                </div>
                <div class="stat-item reveal stagger-4">
                    <div class="stat-number" data-count="100">0</div>
                    <div class="stat-label">% Organic</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══ Testimonials ══ -->
    <section class="section" id="testimonials">
        <div class="reveal" style="text-align:center; margin-bottom:20px;">
            <p class="section-label">What Our Customers Say</p>
            <h2 class="section-title" style="margin-left:auto;margin-right:auto;">Loved by Kitchens Everywhere</h2>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card reveal stagger-1">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"The cloves from Spice Basket have an aroma unlike anything I've found in stores. You can tell they're fresh and hand-sorted. Absolutely worth every rupee!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">P</div>
                    <div>
                        <div class="testimonial-name">Priya Menon</div>
                        <div class="testimonial-location">Kochi, Kerala</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal stagger-2">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"As a professional chef, I need the best ingredients. Spice Basket's black pepper has an incredible bite and warmth that elevates every dish I cook."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">R</div>
                    <div>
                        <div class="testimonial-name">Chef Rahul Sharma</div>
                        <div class="testimonial-location">Mumbai, Maharashtra</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal stagger-3">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"Fast delivery, beautiful packaging, and the turmeric is genuinely golden — you can see the curcumin richness. This is my go-to spice store now."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">A</div>
                    <div>
                        <div class="testimonial-name">Anita Desai</div>
                        <div class="testimonial-location">Bengaluru, Karnataka</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══ Newsletter ══ -->
    <section class="section" id="newsletter">
        <div class="newsletter reveal-scale">
            <p class="section-label">Stay Updated</p>
            <h2 class="section-title" style="text-align:center;">Get Fresh Spice Drops<br>in Your Inbox</h2>
            <p class="section-desc" style="margin:0 auto;text-align:center;">Join 8,000+ spice lovers. Receive recipes, seasonal offers, and first access to new arrivals.</p>
            <form class="newsletter-form" onsubmit="event.preventDefault();">
                <input type="email" class="newsletter-input" placeholder="Your email address" required>
                <button type="submit" class="btn-primary">Subscribe</button>
            </form>
        </div>
    </section>

    <!-- ══ Footer ══ -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div>
                    <div class="nav-brand" style="color:#fff; margin-bottom:8px">
                        <span class="dot"></span> Spice Basket
                    </div>
                    <p class="footer-brand-desc">Dedicated to bringing the finest, ethically sourced spices from Kerala's small-hold farms to your doorstep.</p>
                </div>
                <div>
                    <div class="footer-heading">Quick Links</div>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Farmers Network</a></li>
                        <li><a href="#">Wholesale Inquiry</a></li>
                        <li><a href="#">Gift Cards</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-heading">Support</div>
                    <ul class="footer-links">
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Track Order</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-heading">Contact</div>
                    <ul class="footer-links">
                        <li><a href="#">hello@spicebasket.in</a></li>
                        <li><a href="#">+91 98765 43210</a></li>
                        <li><a href="#">Wayanad, Kerala 673122</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Spice Basket. All rights reserved. Crafted with ❤️ in Kerala.
            </div>
        </div>
    </footer>

    <script>
        // ── Scroll Reveal with IntersectionObserver ──
        const observerOptions = { threshold: 0.15, rootMargin: '0px 0px -50px 0px' };
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
            revealObserver.observe(el);
        });

        // ── Navbar scroll effect ──
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ── Counter animation ──
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-count'));
                    const duration = 2000;
                    const start = performance.now();

                    function update(now) {
                        const elapsed = now - start;
                        const progress = Math.min(elapsed / duration, 1);
                        // Ease out cubic
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
                            if (target >= 1000) {
                                el.textContent = (target / 1000) + 'K+';
                            } else {
                                el.textContent = target + '+';
                            }
                        }
                    }
                    requestAnimationFrame(update);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));

        // ── Smooth scroll for nav links ──
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>

</body>
</html>
