<x-shop-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-semibold">Your cart</h1>
            <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('products.index') }}">Continue shopping</a>
        </div>

        @if(session('status'))
            <div class="mt-4 rounded-xl bg-emerald-50 p-4 text-emerald-700">{{ session('status') }}</div>
        @endif

        @if(!empty($notices))
            <div class="mt-4 space-y-2">
                @foreach($notices as $notice)
                    <div class="rounded-xl bg-amber-50 p-4 text-amber-800">{{ $notice }}</div>
                @endforeach
            </div>
        @endif

        @if(empty($cart))
            <div class="mt-6 rounded-2xl bg-white p-6 text-center shadow-sm">
                <p class="text-gray-600">Your cart is empty.</p>
                <a class="mt-4 inline-block rounded-full bg-emerald-600 px-6 py-3 text-white" href="{{ route('products.index') }}">Shop spices</a>
            </div>
        @else
            <form method="POST" action="{{ route('cart.update') }}" class="mt-6 space-y-4" data-cart-form>
                @csrf
                <div class="space-y-4">
                    @foreach($cart as $item)
                        <div class="rounded-2xl bg-white p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-cart-line data-unit-price="{{ number_format((float) $item['price'], 2, '.', '') }}">
                            <div>
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-600">{{ $item['unit'] }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <input type="number" min="1" max="{{ max((int) ($item['stock_qty'] ?? 1), 1) }}" name="items[{{ $item['key'] }}]" value="{{ $item['quantity'] }}" class="w-24 rounded-xl border-gray-200" data-cart-qty />
                                <span class="font-semibold" data-line-total>INR {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                <button class="text-rose-600" type="submit" name="line_key" value="{{ $item['key'] }}" formaction="{{ route('cart.remove', $item['id']) }}">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <button class="rounded-full border border-emerald-600 px-5 py-2 text-emerald-700" type="submit" data-update-cart-button>Update cart</button>
                    <button class="text-sm text-gray-500" type="submit" formaction="{{ route('cart.clear') }}">Clear cart</button>
                </div>
            </form>

            <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 text-lg font-semibold">
                    <span>Total</span>
                    <span data-cart-total>INR {{ number_format($totals['total'], 2) }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-500">Taxes and shipping are not included for this demo.</p>
                @auth
                    <a class="mt-4 inline-block w-full rounded-full bg-emerald-600 px-6 py-3 text-center text-white" href="{{ route('checkout.index') }}">Proceed to checkout</a>
                @else
                    <a class="mt-4 inline-block w-full rounded-full bg-emerald-600 px-6 py-3 text-center text-white" href="{{ route('login') }}">Login to checkout</a>
                @endauth
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.querySelector('[data-cart-form]');
                    var totalNode = document.querySelector('[data-cart-total]');

                    if (!form || !totalNode) {
                        return;
                    }

                    var quantityInputs = form.querySelectorAll('[data-cart-qty]');
                    if (!quantityInputs.length) {
                        return;
                    }

                    var updateButton = form.querySelector('[data-update-cart-button]');
                    var formatter = new Intl.NumberFormat('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                    var submitTimer = null;
                    var isSubmitting = false;

                    var clampQuantity = function (input) {
                        var min = parseInt(input.getAttribute('min') || '1', 10);
                        var max = parseInt(input.getAttribute('max') || String(Number.MAX_SAFE_INTEGER), 10);
                        var value = parseInt(input.value, 10);

                        if (!Number.isFinite(value)) {
                            value = min;
                        }

                        if (value < min) {
                            value = min;
                        }

                        if (value > max) {
                            value = max;
                        }

                        input.value = String(value);

                        return value;
                    };

                    var recalculateTotals = function () {
                        var total = 0;

                        quantityInputs.forEach(function (input) {
                            var line = input.closest('[data-cart-line]');
                            if (!line) {
                                return;
                            }

                            var unitPrice = parseFloat(line.getAttribute('data-unit-price') || '0');
                            var quantity = clampQuantity(input);
                            var lineTotal = unitPrice * quantity;
                            total += lineTotal;

                            var lineTotalNode = line.querySelector('[data-line-total]');
                            if (lineTotalNode) {
                                lineTotalNode.textContent = 'INR ' + formatter.format(lineTotal);
                            }
                        });

                        totalNode.textContent = 'INR ' + formatter.format(total);
                    };

                    var scheduleSync = function () {
                        if (isSubmitting) {
                            return;
                        }

                        if (submitTimer) {
                            window.clearTimeout(submitTimer);
                        }

                        submitTimer = window.setTimeout(function () {
                            isSubmitting = true;

                            if (typeof form.requestSubmit === 'function') {
                                form.requestSubmit(updateButton || undefined);

                                return;
                            }

                            form.submit();
                        }, 500);
                    };

                    quantityInputs.forEach(function (input) {
                        input.addEventListener('input', function () {
                            recalculateTotals();
                            scheduleSync();
                        });

                        input.addEventListener('change', function () {
                            recalculateTotals();
                            scheduleSync();
                        });
                    });

                    form.addEventListener('submit', function () {
                        isSubmitting = true;

                        if (submitTimer) {
                            window.clearTimeout(submitTimer);
                        }
                    });

                    recalculateTotals();
                });
            </script>
        @endif
    </div>
</x-shop-layout>
