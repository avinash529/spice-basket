<x-shop-layout>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">List of Spices</p>
            <h1 class="mt-2 text-3xl sm:text-4xl font-semibold">Kerala spice guide for home kitchens</h1>
            <p class="mt-4 text-stone-600">
                A quick reference of popular spices, flavor notes, and where to use them in daily cooking.
            </p>
        </div>

        <div class="mt-10 overflow-hidden rounded-3xl border border-stone-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left text-sm">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-5 py-4 font-semibold text-stone-900">Spice</th>
                            <th class="px-5 py-4 font-semibold text-stone-900">Flavor Notes</th>
                            <th class="px-5 py-4 font-semibold text-stone-900">Common Uses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($spices as $spice)
                            <tr>
                                <td class="px-5 py-4 font-semibold">{{ $spice['name'] }}</td>
                                <td class="px-5 py-4 text-stone-600">{{ $spice['notes'] }}</td>
                                <td class="px-5 py-4 text-stone-600">{{ $spice['uses'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-3xl border border-stone-100 bg-white p-6">
                <h2 class="text-2xl font-semibold">Frequently asked questions</h2>
                <div class="mt-5 space-y-4">
                    @foreach($faqs as $faq)
                        <div class="rounded-2xl border border-stone-100 p-4">
                            <h3 class="font-semibold">{{ $faq['question'] }}</h3>
                            <p class="mt-2 text-sm text-stone-600">{{ $faq['answer'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-3xl border border-emerald-100 bg-emerald-50/70 p-6">
                <h2 class="text-xl font-semibold">Need ready-to-cook picks?</h2>
                <p class="mt-3 text-sm text-stone-700">
                    Explore whole spices, powders, and blends from our active catalog. Choose your preferred weight and add directly to cart.
                </p>
                <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-emerald-500">
                    Shop spices
                </a>
            </div>
        </div>
    </section>
</x-shop-layout>

