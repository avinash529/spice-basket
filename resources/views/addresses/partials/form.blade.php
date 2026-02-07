@php
    /** @var \App\Models\Address|null $address */
    $address = $address ?? null;
@endphp

<div class="grid gap-4 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="text-sm font-semibold text-stone-700" for="full_name">Full Name</label>
        <input
            id="full_name"
            class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
            type="text"
            name="full_name"
            value="{{ old('full_name', $address?->full_name) }}"
            required
        />
        <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700" for="phone">Phone</label>
        <input
            id="phone"
            class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
            type="text"
            name="phone"
            value="{{ old('phone', $address?->phone) }}"
            required
        />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700" for="pincode">Pincode</label>
        <input
            id="pincode"
            class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
            type="text"
            maxlength="6"
            name="pincode"
            value="{{ old('pincode', $address?->pincode) }}"
            required
        />
        <x-input-error :messages="$errors->get('pincode')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <label class="text-sm font-semibold text-stone-700" for="house_street">House / Street</label>
        <textarea
            id="house_street"
            class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
            name="house_street"
            rows="3"
            required
        >{{ old('house_street', $address?->house_street) }}</textarea>
        <x-input-error :messages="$errors->get('house_street')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <label class="text-sm font-semibold text-stone-700" for="district">District</label>
        <select
            id="district"
            class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
            name="district"
            required
        >
            <option value="">Select district</option>
            @foreach($districts as $district)
                <option value="{{ $district }}" @selected(old('district', $address?->district) === $district)>
                    {{ $district }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('district')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <label class="inline-flex items-center gap-2 text-sm text-stone-700">
            <input
                type="checkbox"
                class="rounded border-stone-300 text-emerald-600 focus:ring-emerald-200"
                name="is_default"
                value="1"
                @checked(old('is_default', $address?->is_default))
            />
            Set as default address
        </label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button class="rounded-full bg-emerald-600 px-6 py-2 text-white shadow-sm hover:bg-emerald-500" type="submit">
        {{ $submitLabel }}
    </button>
    <a class="text-sm text-emerald-700 hover:text-emerald-600" href="{{ route('addresses.index') }}">Cancel</a>
</div>
