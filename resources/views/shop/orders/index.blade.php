<x-shop-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-semibold">My orders</h1>

        @if(session('status'))
            <div class="mt-4 rounded-xl bg-emerald-50 p-4 text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="mt-6 space-y-4">
            @forelse($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block rounded-2xl bg-white p-5 shadow-sm hover:border-emerald-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-semibold text-emerald-700">{{ ucfirst($order->status) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="font-semibold">INR {{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm">
                    <p class="text-gray-600">No orders yet.</p>
                    <a class="mt-4 inline-block rounded-full bg-emerald-600 px-6 py-3 text-white" href="{{ route('products.index') }}">Shop spices</a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-shop-layout>
