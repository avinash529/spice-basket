<x-shop-layout>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-semibold">Gift Boxes</p>
                <h1 class="mt-2 text-3xl sm:text-4xl font-semibold">Premium spice gift collections</h1>
                <p class="mt-3 text-stone-600 max-w-3xl">
                    Festive hampers, event packs, and presentation-ready assortments that make memorable gifts.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('corporate-gifts.index') }}" class="rounded-full bg-amber-500 px-6 py-3 text-white font-medium shadow-sm hover:bg-amber-400">
                        Bulk corporate inquiry
                    </a>
                    <a href="{{ route('products.index') }}" class="rounded-full border border-amber-300 px-6 py-3 text-amber-700 font-medium hover:bg-amber-50">
                        Browse all products
                    </a>
                </div>
            </div>
            <div class="rounded-3xl border border-amber-100 bg-amber-50/70 p-6">
                <h2 class="text-xl font-semibold">What we support</h2>
                <ul class="mt-4 space-y-2 text-sm text-stone-700">
                    <li>Custom assorted spice packs</li>
                    <li>Festival and wedding return gifts</li>
                    <li>Brand-ready corporate gifting options</li>
                    <li>Pan-India and international shipping</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
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
                        $cardImage = asset('images/cloves.png');
                    }
                @endphp
                <a href="{{ route('products.show', $product->slug) }}" class="group rounded-3xl border border-stone-100 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="relative overflow-hidden rounded-2xl">
                        <img src="{{ $cardImage }}" alt="{{ $product->name }}" class="h-40 w-full object-cover transition duration-500 group-hover:scale-105" />
                        <span class="absolute left-3 top-3 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Gift Ready</span>
                    </div>
                    <h2 class="mt-4 font-semibold">{{ $product->name }}</h2>
                    <p class="mt-1 text-sm text-stone-600">{{ $product->category?->name ?? 'Gift Collection' }}</p>
                    <p class="mt-3 font-semibold">
                        INR {{ number_format($product->displayPrice(), 2) }}
                        @if($product->hasActiveOffer())
                            <span class="ml-2 text-xs font-normal text-stone-400 line-through">INR {{ number_format((float) $product->price, 2) }}</span>
                        @endif
                    </p>
                </a>
            @empty
                <div class="rounded-3xl border border-dashed border-stone-300 bg-white p-8 text-stone-600 sm:col-span-2 lg:col-span-4">
                    Gift box products are not configured yet. Add products tagged with gift/box categories to populate this page.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
</x-shop-layout>
