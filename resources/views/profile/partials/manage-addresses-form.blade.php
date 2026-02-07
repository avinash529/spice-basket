<section>
    <header>
        <p class="text-xs uppercase tracking-[0.25em] text-emerald-600">{{ __('Delivery') }}</p>
        <h2 class="mt-2 text-lg font-semibold text-stone-900">{{ __('Saved Addresses') }}</h2>
        <p class="mt-1 text-sm text-stone-600">{{ __('Manage up to 5 delivery addresses.') }}</p>
    </header>

    @if (session('status') && str_contains((string) session('status'), 'Address'))
        <div class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-sm text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->address->has('address_limit'))
        <div class="mt-4 rounded-2xl border border-rose-100 bg-rose-50/70 p-4 text-sm text-rose-700">
            {{ $errors->address->first('address_limit') }}
        </div>
    @endif

    <div class="mt-4 rounded-2xl border border-stone-100 bg-stone-50/70 p-4 text-sm text-stone-600">
        {{ $addresses->count() }} / {{ $maxAddresses }} addresses used
    </div>

    @if($addresses->count() < $maxAddresses)
        <form method="POST" action="{{ route('addresses.store') }}" class="mt-6 space-y-4">
            @csrf
            <h3 class="text-sm font-semibold text-stone-800">Add New Address</h3>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-stone-700" for="address_full_name">Full Name</label>
                    <input id="address_full_name" name="full_name" type="text" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('full_name') }}" required />
                    <x-input-error class="mt-2" :messages="$errors->address->get('full_name')" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-stone-700" for="address_phone">Phone</label>
                    <input id="address_phone" name="phone" type="text" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('phone', $user->phone) }}" required />
                    <x-input-error class="mt-2" :messages="$errors->address->get('phone')" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-stone-700" for="address_pincode">Pincode</label>
                    <input id="address_pincode" name="pincode" type="text" maxlength="6" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('pincode') }}" required />
                    <x-input-error class="mt-2" :messages="$errors->address->get('pincode')" />
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-stone-700" for="address_house_street">House / Street</label>
                    <textarea id="address_house_street" name="house_street" rows="3" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required>{{ old('house_street') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->address->get('house_street')" />
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-stone-700" for="address_district">District</label>
                    <select id="address_district" name="district" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required>
                        <option value="">Select district</option>
                        @foreach($districts as $district)
                            <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->address->get('district')" />
                </div>
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                <input type="checkbox" class="rounded border-stone-300 text-emerald-600 focus:ring-emerald-200" name="is_default" value="1" @checked(old('is_default')) />
                Set as default
            </label>

            <button class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500" type="submit">
                Add Address
            </button>
        </form>
    @endif

    <div class="mt-6 space-y-4">
        @forelse($addresses as $address)
            <div class="rounded-2xl border border-stone-100 bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div class="text-sm text-stone-700">
                        <div class="flex items-center gap-2">
                            <p class="text-base font-semibold text-stone-900">{{ $address->full_name }}</p>
                            @if($address->is_default)
                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Default</span>
                            @endif
                        </div>
                        <p class="mt-1">{{ $address->phone }}</p>
                        <p class="mt-1 whitespace-pre-line">{{ $address->house_street }}</p>
                        <p class="mt-1">{{ $address->district }} - {{ $address->pincode }}</p>
                    </div>
                    <form method="POST" action="{{ route('addresses.destroy', $address) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-rose-200 px-4 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                    </form>
                </div>

                <details class="mt-4">
                    <summary class="cursor-pointer text-sm font-semibold text-emerald-700 hover:text-emerald-600">Edit address</summary>
                    <form method="POST" action="{{ route('addresses.update', $address) }}" class="mt-4 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label class="text-sm font-semibold text-stone-700" for="full_name_{{ $address->id }}">Full Name</label>
                                <input id="full_name_{{ $address->id }}" name="full_name" type="text" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ $address->full_name }}" required />
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-stone-700" for="phone_{{ $address->id }}">Phone</label>
                                <input id="phone_{{ $address->id }}" name="phone" type="text" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ $address->phone }}" required />
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-stone-700" for="pincode_{{ $address->id }}">Pincode</label>
                                <input id="pincode_{{ $address->id }}" name="pincode" type="text" maxlength="6" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ $address->pincode }}" required />
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-sm font-semibold text-stone-700" for="house_street_{{ $address->id }}">House / Street</label>
                                <textarea id="house_street_{{ $address->id }}" name="house_street" rows="3" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required>{{ $address->house_street }}</textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-sm font-semibold text-stone-700" for="district_{{ $address->id }}">District</label>
                                <select id="district_{{ $address->id }}" name="district" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required>
                                    @foreach($districts as $district)
                                        <option value="{{ $district }}" @selected($address->district === $district)>{{ $district }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <label class="inline-flex items-center gap-2 text-sm text-stone-700">
                            <input type="checkbox" class="rounded border-stone-300 text-emerald-600 focus:ring-emerald-200" name="is_default" value="1" @checked($address->is_default) />
                            Set as default
                        </label>

                        <button class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500" type="submit">
                            Update Address
                        </button>
                    </form>
                </details>
            </div>
        @empty
            <div class="rounded-2xl border border-stone-100 bg-stone-50/70 p-4 text-sm text-stone-600">
                No saved addresses yet.
            </div>
        @endforelse
    </div>
</section>
