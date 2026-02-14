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
                <a href="{{ route('products.show', $product->slug) }}" class="group block rounded-3xl border border-stone-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-300">
                    <div class="relative overflow-hidden rounded-2xl">
                        <img src="{{ $cardImage }}" alt="{{ $product->name }}" class="h-44 w-full object-cover transition duration-500 group-hover:scale-105" />
                        <div class="absolute top-4 left-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-stone-700">{{ $product->origin ?? 'Single origin' }}</div>
                    </div>
                    <h3 class="mt-4 font-semibold text-lg">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-stone-600">{{ $product->unit }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="font-semibold">
                            INR {{ number_format($product->displayPrice(), 2) }}
                            @if($product->hasActiveOffer())
                                <span class="ml-2 text-xs font-normal text-stone-400 line-through">INR {{ number_format((float) $product->price, 2) }}</span>
                            @endif
                        </span>
                        <span class="text-emerald-700 group-hover:text-emerald-600">View</span>
                    </div>
                </a>
            @empty
                <p class="text-stone-600">No featured spices yet. Add some in the admin panel.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white/70 border-y border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-rose-700 font-semibold">Flash deals</p>
                    <h2 class="mt-2 text-2xl font-semibold">Latest offers</h2>
                </div>
                <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('offers.index') }}">See all offers</a>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
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
                    <a href="{{ route('products.show', $product->slug) }}" class="group rounded-3xl border border-stone-100 bg-white p-4 shadow-sm hover:-translate-y-1 hover:shadow-md transition">
                        <div class="relative overflow-hidden rounded-2xl">
                            <img src="{{ $offerImage }}" alt="{{ $product->name }}" class="h-36 w-full object-cover transition duration-500 group-hover:scale-105" />
                            <span class="absolute left-3 top-3 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                {{ $product->activeOfferLabel() ?? 'Hot deal' }}
                            </span>
                        </div>
                        <p class="mt-4 font-semibold">{{ $product->name }}</p>
                        <p class="mt-1 text-sm text-stone-600">{{ $product->unit }}</p>
                        <p class="mt-2 font-semibold">
                            INR {{ number_format($product->displayPrice(), 2) }}
                            @if($product->hasActiveOffer())
                                <span class="ml-2 text-xs font-normal text-stone-400 line-through">INR {{ number_format((float) $product->price, 2) }}</span>
                            @endif
                        </p>
                    </a>
                @empty
                    <p class="text-stone-600">No active offers right now.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-8 lg:grid-cols-[1fr_1.2fr] items-center">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-semibold">Gift hampers</p>
                <h2 class="mt-2 text-3xl font-semibold">Gift boxes for festivals, weddings, and corporate events</h2>
                <p class="mt-4 text-stone-600">
                    Choose curated spice collections in premium packaging. We can help with bulk orders, personalized packs, and event-ready delivery.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('gift-boxes.index') }}" class="rounded-full bg-amber-500 px-6 py-3 text-white font-medium shadow-sm hover:bg-amber-400">Explore gift boxes</a>
                    <a href="{{ route('corporate-gifts.index') }}" class="rounded-full border border-amber-400 px-6 py-3 text-amber-700 font-medium hover:bg-amber-50">Corporate gifting</a>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
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
                    <a href="{{ route('products.show', $product->slug) }}" class="group rounded-3xl border border-stone-100 bg-white p-4 shadow-sm hover:-translate-y-1 hover:shadow-md transition">
                        <div class="relative overflow-hidden rounded-2xl">
                            <img src="{{ $giftImage }}" alt="{{ $product->name }}" class="h-36 w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <p class="mt-4 font-semibold">{{ $product->name }}</p>
                        <p class="mt-2 text-sm text-stone-600">{{ $product->category?->name ?? 'Gift Collection' }}</p>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-stone-300 p-6 bg-white/80 sm:col-span-2">
                        <p class="text-stone-600">Gift boxes will appear here once products are added in relevant categories.</p>
                    </div>
                @endforelse
            </div>
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

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-stone-100 bg-white p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Authentic sourcing</p>
                <h3 class="mt-3 text-xl font-semibold">Direct from partner farmers</h3>
                <p class="mt-3 text-sm text-stone-600">Transparent sourcing and fair partnerships help us maintain quality at every batch.</p>
            </div>
            <div class="rounded-3xl border border-stone-100 bg-white p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-sky-700 font-semibold">Customer support</p>
                <h3 class="mt-3 text-xl font-semibold">Fast response and order assistance</h3>
                <p class="mt-3 text-sm text-stone-600">Need product help, bulk packing, or order updates? We respond quickly and stay accountable.</p>
            </div>
            <div class="rounded-3xl border border-stone-100 bg-white p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-semibold">Trusted by customers</p>
                <h3 class="mt-3 text-xl font-semibold">Consistent quality and repeat orders</h3>
                <p class="mt-3 text-sm text-stone-600">Thousands of repeat customers rely on our freshness, aroma, and reliable packing quality.</p>
            </div>
        </div>
    </section>
</x-shop-layout>
