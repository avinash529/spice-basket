<x-shop-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Your cart</h1>
            <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('products.index') }}">Continue shopping</a>
        </div>

        @if(session('status'))
            <div class="mt-4 rounded-xl bg-emerald-50 p-4 text-emerald-700">{{ session('status') }}</div>
        @endif

        @if(empty($cart))
            <div class="mt-6 rounded-2xl bg-white p-6 text-center shadow-sm">
                <p class="text-gray-600">Your cart is empty.</p>
                <a class="mt-4 inline-block rounded-full bg-emerald-600 px-6 py-3 text-white" href="{{ route('products.index') }}">Shop spices</a>
            </div>
        @else
            <form method="POST" action="{{ route('cart.update') }}" class="mt-6 space-y-4">
                @csrf
                <div class="space-y-4">
                    @foreach($cart as $item)
                        <div class="rounded-2xl bg-white p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-600">{{ $item['unit'] }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <input type="number" min="1" name="items[{{ $item['key'] }}]" value="{{ $item['quantity'] }}" class="w-24 rounded-xl border-gray-200" />
                                <span class="font-semibold">INR {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                <button class="text-rose-600" type="submit" name="line_key" value="{{ $item['key'] }}" formaction="{{ route('cart.remove', $item['id']) }}">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between">
                    <button class="rounded-full border border-emerald-600 px-5 py-2 text-emerald-700" type="submit">Update cart</button>
                    <button class="text-sm text-gray-500" type="submit" formaction="{{ route('cart.clear') }}">Clear cart</button>
                </div>
            </form>

            <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between text-lg font-semibold">
                    <span>Total</span>
                    <span>INR {{ number_format($totals['total'], 2) }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-500">Taxes and shipping are not included for this demo.</p>
                @auth
                    <a class="mt-4 inline-block w-full rounded-full bg-emerald-600 px-6 py-3 text-center text-white" href="{{ route('checkout.index') }}">Proceed to checkout</a>
                @else
                    <a class="mt-4 inline-block w-full rounded-full bg-emerald-600 px-6 py-3 text-center text-white" href="{{ route('login') }}">Login to checkout</a>
                @endauth
            </div>
        @endif
    </div>
</x-shop-layout>
