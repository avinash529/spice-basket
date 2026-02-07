<x-shop-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @php
            $heroImage = $product->image_url;
            if ($heroImage) {
                if (\Illuminate\Support\Str::startsWith($heroImage, ['http://', 'https://'])) {
                    $heroImage = $heroImage;
                } elseif (\Illuminate\Support\Str::startsWith($heroImage, ['storage/', 'images/'])) {
                    $heroImage = asset($heroImage);
                } else {
                    $heroImage = asset('storage/' . $heroImage);
                }
            } else {
                $heroImage = asset('images/turmeric.png');
            }
        @endphp
        <div class="grid gap-8 lg:grid-cols-2">
            @php
                $weightOptions = $product->weightOptions();
                $weightPriceMap = $product->weightPriceMap();
                $defaultWeight = old('selected_weight', $weightOptions[0] ?? $product->unit);
                $displayPrice = !empty($weightOptions)
                    ? $product->priceForWeight((string) $defaultWeight)
                    : (float) $product->price;
            @endphp
            <div class="relative overflow-hidden rounded-3xl bg-emerald-50 h-80">
                <img src="{{ $heroImage }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-tr from-stone-900/10 via-transparent to-amber-200/30"></div>
            </div>
            <div>
                <h1 class="text-3xl font-semibold">{{ $product->name }}</h1>
                <p class="mt-2 text-stone-600">{{ $product->origin ?? 'Single origin' }} · {{ $product->unit }}</p>
                <p class="mt-4 text-2xl font-semibold">
                    INR <span id="product-price">{{ number_format($displayPrice, 2) }}</span>
                </p>
                <p class="mt-4 text-stone-700">{{ $product->description ?? 'Freshly sourced spice from our farmer partners.' }}</p>

                <form class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-end" method="POST" action="{{ route('cart.add', $product) }}">
                    @csrf
                    @if(!empty($weightOptions))
                        <div>
                            <label class="text-sm font-semibold text-stone-700" for="selected_weight">Weight</label>
                            <select id="selected_weight" name="selected_weight" class="mt-2 w-40 rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200">
                                @foreach($weightOptions as $weightOption)
                                    @php
                                        $weightPrice = $weightPriceMap[$weightOption] ?? (float) $product->price;
                                    @endphp
                                    <option value="{{ $weightOption }}" data-price="{{ number_format($weightPrice, 2, '.', '') }}" @selected($defaultWeight === $weightOption)>
                                        {{ $weightOption }} - INR {{ number_format($weightPrice, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('selected_weight')" class="mt-2" />
                        </div>
                    @else
                        <input type="hidden" name="selected_weight" value="{{ $product->unit }}" />
                    @endif
                    <input type="number" min="1" name="quantity" value="1" class="w-24 rounded-xl border-gray-200" />
                    <button class="rounded-full bg-emerald-600 px-6 py-3 text-white hover:bg-emerald-500" type="submit">Add to cart</button>
                </form>
                @if(!empty($weightOptions))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var weightSelect = document.getElementById('selected_weight');
                            var priceNode = document.getElementById('product-price');

                            if (!weightSelect || !priceNode) {
                                return;
                            }

                            var syncPrice = function () {
                                var selected = weightSelect.options[weightSelect.selectedIndex];
                                var price = selected ? selected.getAttribute('data-price') : null;
                                if (price) {
                                    priceNode.textContent = Number(price).toFixed(2);
                                }
                            };

                            weightSelect.addEventListener('change', syncPrice);
                            syncPrice();
                        });
                    </script>
                @endif

                <div class="mt-6 grid gap-2 text-sm text-stone-600">
                    <p>Category: {{ $product->category?->name ?? 'General' }}</p>
                    <p>Farmer: {{ $product->farmer?->name ?? 'Community partner' }}</p>
                    <p>Stock: {{ $product->stock_qty }}</p>
                </div>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-xl font-semibold">You may also like</h2>
            <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($related as $item)
                    @php
                        $relatedImage = $item->image_url;
                        if ($relatedImage) {
                            if (\Illuminate\Support\Str::startsWith($relatedImage, ['http://', 'https://'])) {
                                $relatedImage = $relatedImage;
                            } elseif (\Illuminate\Support\Str::startsWith($relatedImage, ['storage/', 'images/'])) {
                                $relatedImage = asset($relatedImage);
                            } else {
                                $relatedImage = asset('storage/' . $relatedImage);
                            }
                        } else {
                            $relatedImage = asset('images/cloves.png');
                        }
                    @endphp
                    <a href="{{ route('products.show', $item->slug) }}" class="group rounded-2xl border border-stone-100 bg-white p-4 shadow-sm hover:border-emerald-200 hover:shadow-md">
                        <div class="relative overflow-hidden rounded-xl">
                            <img src="{{ $relatedImage }}" alt="{{ $item->name }}" class="h-24 w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <p class="mt-3 font-semibold">{{ $item->name }}</p>
                        <p class="mt-1 text-sm text-stone-600">INR {{ number_format($item->price, 2) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-shop-layout>
