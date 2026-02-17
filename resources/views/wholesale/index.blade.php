<x-shop-layout>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-6 sm:p-8">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-700 font-semibold">Wholesale Portal</p>
            <h1 class="mt-2 text-3xl font-semibold text-stone-900">Bulk and Wholesale Information</h1>
            <p class="mt-3 text-stone-700">
                Welcome, {{ $user->name }}. This section contains wholesale-specific content managed by admin.
            </p>
        </div>

        @if($contents->isEmpty())
            <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-stone-600">No wholesale content is active right now. Please check back later.</p>
            </div>
        @else
            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                @foreach($contents as $content)
                    <article class="rounded-3xl border border-stone-100 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-stone-900">{{ $content->title }}</h2>
                                @if($content->summary)
                                    <p class="mt-2 text-sm text-stone-600">{{ $content->summary }}</p>
                                @endif
                            </div>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Wholesale</span>
                        </div>

                        @if($content->content)
                            <p class="mt-4 whitespace-pre-line text-sm leading-6 text-stone-700">{{ $content->content }}</p>
                        @endif

                        <div class="mt-5 flex flex-wrap items-center gap-3 text-sm">
                            @if($content->cta_label && $content->cta_url)
                                <a href="{{ $content->cta_url }}" class="rounded-full bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-500">
                                    {{ $content->cta_label }}
                                </a>
                            @endif
                            @if($content->contact_email)
                                <a href="mailto:{{ $content->contact_email }}" class="text-emerald-700 hover:text-emerald-600">
                                    {{ $content->contact_email }}
                                </a>
                            @endif
                            @if($content->contact_phone)
                                <a href="tel:{{ $content->contact_phone }}" class="text-emerald-700 hover:text-emerald-600">
                                    {{ $content->contact_phone }}
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-shop-layout>
