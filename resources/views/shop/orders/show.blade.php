<x-shop-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-semibold">Order #{{ $order->id }}</h1>
            <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('dashboard') }}">Back to orders</a>
        </div>

        <div class="mt-4 rounded-2xl bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-sm text-gray-500">Placed on</p>
                    <p class="font-semibold">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold text-emerald-700">{{ ucfirst($order->status) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="font-semibold">INR {{ number_format($order->total, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="font-semibold">Delivery address</h2>
            @if($order->shipping_full_name)
                <div class="mt-3 text-sm text-gray-700">
                    <p class="font-semibold text-gray-900">{{ $order->shipping_full_name }}</p>
                    <p class="mt-1">{{ $order->shipping_phone }}</p>
                    <p class="mt-1 whitespace-pre-line">{{ $order->shipping_house_street }}</p>
                    <p class="mt-1">{{ $order->shipping_district }} - {{ $order->shipping_pincode }}</p>
                </div>
            @else
                <p class="mt-3 text-sm text-gray-500">Address details are unavailable for this order.</p>
            @endif
        </div>

        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="font-semibold">Tracking timeline</h2>
            <div class="mt-4 space-y-3 text-sm">
                @forelse($order->statusHistory as $history)
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 pb-3">
                        <div>
                            <p class="font-semibold">{{ ucfirst($history->status) }}</p>
                            @if($history->note)
                                <p class="text-gray-500">{{ $history->note }}</p>
                            @endif
                        </div>
                        <span class="text-gray-500">{{ $history->created_at->format('M d, Y H:i') }}</span>
                    </div>
                @empty
                    <p class="text-gray-600">Tracking will appear as your order is processed.</p>
                @endforelse
            </div>
        </div>

        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="font-semibold">Items</h2>
            <div class="mt-4 space-y-3">
                @foreach($order->items as $item)
                    <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                        <span>{{ $item->product->name ?? 'Product' }} x {{ $item->quantity }}</span>
                        <span>INR {{ number_format($item->line_total, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-shop-layout>
