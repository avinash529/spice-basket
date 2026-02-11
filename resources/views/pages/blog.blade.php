<x-shop-layout>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl">
            <p class="text-xs uppercase tracking-[0.2em] text-sky-700 font-semibold">Blog</p>
            <h1 class="mt-2 text-4xl font-semibold">Practical spice guides and kitchen insights</h1>
            <p class="mt-4 text-stone-600">
                Learn buying basics, storage tips, and flavor techniques that help you cook better with less guesswork.
            </p>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <article class="rounded-3xl border border-stone-100 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.15em] text-sky-700 font-semibold">{{ $post['tag'] }}</p>
                    <h2 class="mt-3 text-xl font-semibold leading-snug">{{ $post['title'] }}</h2>
                    <p class="mt-3 text-sm text-stone-600">{{ $post['excerpt'] }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-stone-500">
                        <span>{{ $post['published_at'] }}</span>
                        <span>{{ $post['read_time'] }}</span>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10 rounded-3xl border border-stone-100 bg-white p-6 sm:p-8">
            <h2 class="text-2xl font-semibold">Looking for products mentioned in the blog?</h2>
            <p class="mt-3 text-stone-600">Explore the latest stock across whole spices, powders, and curated blends.</p>
            <a href="{{ route('products.index') }}" class="mt-5 inline-flex rounded-full bg-emerald-600 px-6 py-3 text-white font-medium hover:bg-emerald-500">
                Browse products
            </a>
        </div>
    </section>
</x-shop-layout>

