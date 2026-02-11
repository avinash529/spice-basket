<x-shop-layout>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-start">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-amber-700 font-semibold">Corporate Gift Boxes</p>
                <h1 class="mt-2 text-4xl font-semibold">Bulk gifting with custom branding support</h1>
                <p class="mt-4 text-stone-600">
                    Build memorable gifts for clients, teams, and events with premium Kerala spices and curated hampers.
                </p>

                <div class="mt-6 rounded-3xl border border-amber-100 bg-amber-50/70 p-6">
                    <h2 class="text-xl font-semibold">Available options</h2>
                    <ul class="mt-4 space-y-2 text-sm text-stone-700">
                        <li>Customized gift boxes or hampers (spices, oils, savories)</li>
                        <li>Wooden and acrylic box formats</li>
                        <li>Dry fruit and mixed gift pack options</li>
                        <li>Branding support for company logos and event notes</li>
                        <li>Typical price range: INR 400 to INR 4000</li>
                    </ul>
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-semibold">Popular gift-ready products</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @forelse($giftProducts as $product)
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
                            <a href="{{ route('products.show', $product->slug) }}" class="group rounded-2xl border border-stone-100 bg-white p-4 shadow-sm hover:-translate-y-1 hover:shadow-md transition">
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="{{ $cardImage }}" alt="{{ $product->name }}" class="h-32 w-full object-cover transition duration-500 group-hover:scale-105" />
                                </div>
                                <p class="mt-3 font-semibold text-sm">{{ $product->name }}</p>
                                <p class="mt-1 text-xs text-stone-600">{{ $product->category?->name ?? 'Gift Collection' }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-stone-600">Gift collection products will appear here once configured.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-semibold">Get in touch</h2>
                <p class="mt-2 text-sm text-stone-600">Share your quantity, timeline, and preferred box style. We will respond quickly.</p>

                @if(session('status'))
                    <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('corporate-gifts.inquiry') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-stone-700" for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700" for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700" for="phone">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700" for="company">Company (optional)</label>
                        <input id="company" name="company" type="text" value="{{ old('company') }}" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" />
                        <x-input-error :messages="$errors->get('company')" class="mt-2" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-stone-700" for="message">Requirement</label>
                        <textarea id="message" name="message" rows="5" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required>{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <button type="submit" class="w-full rounded-full bg-emerald-600 px-5 py-3 text-white font-medium hover:bg-emerald-500">
                        Submit inquiry
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-shop-layout>

