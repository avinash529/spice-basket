<x-shop-layout>
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(16,185,129,0.12),_transparent_55%)]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] items-center">
                <div>
                    <p class="text-emerald-600 font-semibold uppercase tracking-[0.2em] text-xs">Farm-to-kitchen spices</p>
                    <h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl font-semibold text-stone-900">Fresh spices sourced directly from trusted farmers.</h1>
                    <p class="mt-5 text-stone-600 text-lg">Discover single-origin turmeric, pepper, cardamom, and more. We keep it transparent, traceable, and flavorful from harvest to your kitchen.</p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('products.index') }}" class="rounded-full bg-emerald-600 px-6 py-3 text-white font-medium shadow-sm hover:bg-emerald-500">Shop spices</a>
                        <a href="#categories" class="rounded-full border border-emerald-600 px-6 py-3 text-emerald-700 font-medium hover:bg-emerald-50">Browse categories</a>
                    </div>
                    <div class="mt-10 grid grid-cols-3 gap-6 text-sm text-stone-600">
                        <div>
                            <p class="text-2xl font-semibold text-stone-900">120+</p>
                            <p>Farmer partners</p>
                        </div>
                        <div>
                            <p class="text-2xl font-semibold text-stone-900">36 hrs</p>
                            <p>Roast to pack</p>
                        </div>
                        <div>
                            <p class="text-2xl font-semibold text-stone-900">4.9/5</p>
                            <p>Customer ratings</p>
                        </div>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="relative overflow-hidden rounded-3xl shadow-lg">
                        <img src="{{ asset('images/turmeric.png') }}" alt="Spices in bowls" class="h-64 w-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-900/60 via-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <p class="text-sm uppercase tracking-[0.25em]">Signature</p>
                            <p class="text-lg font-semibold">Golden Turmeric</p>
                        </div>
                    </div>
                    <div class="relative overflow-hidden rounded-3xl shadow-lg">
                        <img src="{{ asset('images/black_pepper.png') }}" alt="Whole spices" class="h-64 w-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-900/60 via-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <p class="text-sm uppercase tracking-[0.25em]">Fresh</p>
                            <p class="text-lg font-semibold">Black Pepper</p>
                        </div>
                    </div>
                    <div class="rounded-3xl bg-white p-6 shadow-lg sm:col-span-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-emerald-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Direct sourcing</p>
                                <p class="mt-2 text-stone-600 text-sm">Farmer-first partnerships, fair prices.</p>
                            </div>
                            <div class="rounded-2xl bg-amber-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-semibold">Quality checks</p>
                                <p class="mt-2 text-stone-600 text-sm">Small batches, sealed freshness.</p>
                            </div>
                            <div class="rounded-2xl bg-rose-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-rose-700 font-semibold">Traceable origin</p>
                                <p class="mt-2 text-stone-600 text-sm">Know the farm and harvest.</p>
                            </div>
                            <div class="rounded-2xl bg-sky-50 p-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-sky-700 font-semibold">Fast shipping</p>
                                <p class="mt-2 text-stone-600 text-sm">Packed fresh, delivered quickly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold">Featured spices</h2>
            <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('products.index') }}">View all</a>
        </div>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
                <div class="group rounded-3xl border border-stone-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative overflow-hidden rounded-2xl">
                        <img src="{{ $cardImage }}" alt="{{ $product->name }}" class="h-44 w-full object-cover transition duration-500 group-hover:scale-105" />
                        <div class="absolute top-4 left-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-stone-700">{{ $product->origin ?? 'Single origin' }}</div>
                    </div>
                    <h3 class="mt-4 font-semibold text-lg">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-stone-600">{{ $product->unit }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="font-semibold">INR {{ number_format($product->price, 2) }}</span>
                        <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('products.show', $product->slug) }}">View</a>
                    </div>
                </div>
            @empty
                <p class="text-stone-600">No featured spices yet. Add some in the admin panel.</p>
            @endforelse
        </div>
    </section>

    <section id="categories" class="bg-white/70 border-t border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-semibold">Shop by category</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group rounded-3xl border border-stone-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">
                        <div class="h-24 rounded-2xl bg-emerald-50/70 flex items-center justify-center text-emerald-700 font-semibold">{{ strtoupper(substr($category->name, 0, 1)) }}</div>
                        <p class="mt-4 font-semibold">{{ $category->name }}</p>
                        <p class="mt-2 text-sm text-stone-600">{{ $category->products_count }} items</p>
                    </a>
                @empty
                    <p class="text-stone-600">No categories yet.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-shop-layout>
