<x-shop-layout>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-rose-700 font-semibold">Latest Offer</p>
                <h1 class="mt-2 text-4xl font-semibold">Fresh deals on Kerala spices</h1>
                <p class="mt-3 text-stone-600 max-w-3xl">
                    Curated picks from our active catalog, including best sellers and recently updated products.
                </p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-full border border-emerald-200 bg-white px-5 py-2.5 text-sm font-medium text-emerald-700 hover:bg-emerald-50">
                View full catalog
            </a>
        </div>

        <div class="mt-8 flex flex-wrap gap-2">
            <a href="{{ route('offers.index') }}" class="rounded-full border px-4 py-2 text-sm {{ request('category') ? 'border-stone-200 bg-white text-stone-700' : 'border-rose-200 bg-rose-50 text-rose-700 font-semibold' }}">
                All offers
            </a>
            @foreach($categories as $category)
                <a
                    href="{{ route('offers.index', ['category' => $category->slug]) }}"
                    class="rounded-full border px-4 py-2 text-sm {{ request('category') === $category->slug ? 'border-rose-200 bg-rose-50 text-rose-700 font-semibold' : 'border-stone-200 bg-white text-stone-700 hover:border-rose-200 hover:text-rose-700' }}"
                >
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($products as $product)
                @php
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
                        $cardImage = asset('images/black_pepper.png');
                    }
                @endphp
                <a href="{{ route('products.show', $product->slug) }}" class="group rounded-3xl border border-stone-100 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="relative overflow-hidden rounded-2xl">
                        <img src="{{ $cardImage }}" alt="{{ $product->name }}" class="h-40 w-full object-cover transition duration-500 group-hover:scale-105" />
                        <span class="absolute left-3 top-3 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                            {{ $product->activeOfferLabel() ?? ($product->is_featured ? 'Featured Deal' : 'Limited Offer') }}
                        </span>
                    </div>
                    <h2 class="mt-4 font-semibold">{{ $product->name }}</h2>
                    <p class="mt-1 text-sm text-stone-600">{{ $product->category?->name ?? 'Spices' }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <p class="font-semibold">
                            INR {{ number_format($product->displayPrice(), 2) }}
                            @if($product->hasActiveOffer())
                                <span class="ml-2 text-xs font-normal text-stone-400 line-through">INR {{ number_format((float) $product->price, 2) }}</span>
                            @endif
                        </p>
                        <span class="text-sm text-emerald-700">View</span>
                    </div>
                </a>
            @empty
                <div class="rounded-3xl border border-dashed border-stone-300 bg-white p-8 text-stone-600 sm:col-span-2 lg:col-span-4">
                    No active offers available in this filter right now.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
</x-shop-layout>
