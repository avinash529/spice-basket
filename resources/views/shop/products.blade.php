<x-shop-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="lg:w-1/4 space-y-6">
                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <h2 class="font-semibold text-lg">Search</h2>
                    <form class="mt-4" method="GET" action="{{ route('products.index') }}">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Turmeric, pepper..." class="w-full rounded-xl border-gray-200" />
                        <button class="mt-3 w-full rounded-xl bg-emerald-600 py-2 text-white hover:bg-emerald-500" type="submit">Search</button>
                    </form>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <h2 class="font-semibold text-lg">Categories</h2>
                    <div class="mt-4 space-y-2 text-sm">
                        <a class="block {{ request('category') ? '' : 'text-emerald-600 font-semibold' }}" href="{{ route('products.index') }}">All spices</a>
                        @foreach($categories as $category)
                            <a class="block {{ request('category') === $category->slug ? 'text-emerald-600 font-semibold' : '' }}" href="{{ route('products.index', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <section class="flex-1">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold">Spices</h1>
                    <span class="text-sm text-stone-500">{{ $products->total() }} items</span>
                </div>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
                                $cardImage = asset('images/turmeric.png');
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
                        <p class="text-stone-600">No products found.</p>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </section>
        </div>
    </div>
</x-shop-layout>
