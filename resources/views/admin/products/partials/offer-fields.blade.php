@php
    $currentProduct = $product ?? null;
    $offerModes = \App\Models\Product::offerModeLabels();
    $selectedOfferMode = old('offer_mode', $currentProduct->offer_mode ?? \App\Models\Product::OFFER_MODE_NONE);
@endphp

<div class="rounded-2xl border border-amber-100 bg-amber-50/40 p-4 space-y-4">
    <div>
        <p class="text-xs uppercase tracking-[0.2em] text-amber-700">Offers</p>
        <h3 class="mt-1 text-sm font-semibold text-stone-900">Festival & Normal Offers</h3>
        <p class="mt-1 text-xs text-stone-600">Set offer percentages for Kerala festivals and choose which offer is currently active for this product.</p>
    </div>

    <div>
        <label class="block text-sm font-medium text-stone-700">Active offer</label>
        <select class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="offer_mode">
            @foreach ($offerModes as $mode => $label)
                <option value="{{ $mode }}" @selected($selectedOfferMode === $mode)>{{ $label }}</option>
            @endforeach
        </select>
        @error('offer_mode')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-stone-700">Normal offer %</label>
            <input
                class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
                type="number"
                name="normal_offer_percent"
                min="0"
                max="100"
                step="0.01"
                value="{{ old('normal_offer_percent', $currentProduct->normal_offer_percent ?? '') }}"
            />
            @error('normal_offer_percent')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Vishu offer %</label>
            <input
                class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
                type="number"
                name="vishu_offer_percent"
                min="0"
                max="100"
                step="0.01"
                value="{{ old('vishu_offer_percent', $currentProduct->vishu_offer_percent ?? '') }}"
            />
            @error('vishu_offer_percent')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Onam offer %</label>
            <input
                class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
                type="number"
                name="onam_offer_percent"
                min="0"
                max="100"
                step="0.01"
                value="{{ old('onam_offer_percent', $currentProduct->onam_offer_percent ?? '') }}"
            />
            @error('onam_offer_percent')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Christmas offer %</label>
            <input
                class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
                type="number"
                name="christmas_offer_percent"
                min="0"
                max="100"
                step="0.01"
                value="{{ old('christmas_offer_percent', $currentProduct->christmas_offer_percent ?? '') }}"
            />
            @error('christmas_offer_percent')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
</div>
