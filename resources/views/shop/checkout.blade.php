<x-shop-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-semibold">Checkout</h1>
        <p class="mt-2 text-gray-600">Demo checkout. No payment is collected.</p>

        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="font-semibold">Order summary</h2>
            <div class="mt-4 space-y-3">
                @foreach($cart as $item)
                    <div class="flex items-center justify-between text-sm">
                        <span>{{ $item['name'] }} ({{ $item['unit'] }}) x {{ $item['quantity'] }}</span>
                        <span>INR {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex items-center justify-between font-semibold">
                <span>Total</span>
                <span>INR {{ number_format($totals['total'], 2) }}</span>
            </div>
        </div>

        <form class="mt-6" method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="font-semibold">Delivery address</h2>
                    <a class="text-sm text-emerald-700 hover:text-emerald-600" href="{{ route('profile.edit') }}#addresses">Manage in profile</a>
                </div>

                @if($addresses->isEmpty())
                    <div class="mt-4 rounded-xl bg-amber-50 p-4 text-sm text-amber-800">
                        No saved address found. Add your delivery address to place this order.
                    </div>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-stone-700" for="full_name">Full Name</label>
                            <input id="full_name" type="text" name="full_name" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('full_name', auth()->user()->name) }}" required>
                            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-stone-700" for="phone">Phone</label>
                            <input id="phone" type="text" name="phone" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('phone', auth()->user()->phone) }}" required>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-stone-700" for="pincode">Pincode</label>
                            <input id="pincode" type="text" name="pincode" maxlength="6" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('pincode') }}" required>
                            <x-input-error :messages="$errors->get('pincode')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-stone-700" for="house_street">House / Street</label>
                            <textarea id="house_street" name="house_street" rows="3" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required>{{ old('house_street') }}</textarea>
                            <x-input-error :messages="$errors->get('house_street')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-stone-700" for="district">District</label>
                            <select id="district" name="district" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" required>
                                <option value="">Select district</option>
                                @foreach(\App\Support\Kerala::DISTRICTS as $district)
                                    <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('district')" class="mt-2" />
                        </div>
                    </div>
                @else
                    <div class="mt-4 space-y-3">
                        @foreach($addresses as $address)
                            <label class="block cursor-pointer rounded-xl border border-stone-200 p-4 hover:border-emerald-200">
                                <div class="flex items-start gap-3">
                                    <input
                                        type="radio"
                                        name="address_id"
                                        value="{{ $address->id }}"
                                        class="mt-1 border-stone-300 text-emerald-600 focus:ring-emerald-200"
                                        @checked(old('address_id', $addresses->firstWhere('is_default', true)?->id ?? $addresses->first()->id) == $address->id)
                                        required
                                    />
                                    <div class="text-sm text-stone-700">
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold text-stone-900">{{ $address->full_name }}</p>
                                            @if($address->is_default)
                                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Default</span>
                                            @endif
                                        </div>
                                        <p class="mt-1">{{ $address->phone }}</p>
                                        <p class="mt-1">{{ $address->house_street }}</p>
                                        <p class="mt-1">{{ $address->district }} - {{ $address->pincode }}</p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('address_id')" class="mt-3" />
                @endif
            </div>

            <button class="mt-6 w-full rounded-full bg-emerald-600 px-6 py-3 text-white" type="submit">
                Place order
            </button>
        </form>
    </div>
</x-shop-layout>
