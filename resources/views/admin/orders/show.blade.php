<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Orders</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Order #{{ $order->id }}</h2>
            </div>
            <a class="text-sm text-emerald-700" href="{{ route('admin.orders.index') }}">Back to orders</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="grid gap-4 sm:grid-cols-3 text-sm">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Customer</p>
                        <p class="mt-2 font-semibold text-stone-800">{{ $order->user->name ?? 'Customer' }}</p>
                        <p class="text-stone-500">{{ $order->user->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Placed</p>
                        <p class="mt-2 font-semibold text-stone-800">{{ $order->created_at->format('M d, Y') }}</p>
                        <p class="text-stone-500">{{ $order->created_at->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Total</p>
                        <p class="mt-2 text-2xl font-semibold text-stone-900">INR {{ number_format($order->total, 2) }}</p>
                        <span class="mt-2 inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ ucfirst($order->status ?? 'pending') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Delivery</p>
                    <h3 class="text-lg font-semibold text-stone-900">Shipping address</h3>
                </div>
                @if($order->shipping_full_name)
                    <div class="mt-4 text-sm text-stone-700">
                        <p class="font-semibold text-stone-900">{{ $order->shipping_full_name }}</p>
                        <p class="mt-1">{{ $order->shipping_phone }}</p>
                        <p class="mt-2 whitespace-pre-line">{{ $order->shipping_house_street }}</p>
                        <p class="mt-1">{{ $order->shipping_district }} - {{ $order->shipping_pincode }}</p>
                    </div>
                @else
                    <p class="mt-4 text-sm text-stone-500">Address details are unavailable for this order.</p>
                @endif
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Tracking</p>
                        <h3 class="text-lg font-semibold text-stone-900">Order timeline</h3>
                    </div>
                </div>
                <div class="mt-4 space-y-3 text-sm">
                    @forelse($order->statusHistory as $history)
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-stone-100 pb-3">
                            <div class="flex items-start gap-3">
                                <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                                <div>
                                    <p class="font-semibold text-stone-800">{{ ucfirst($history->status) }}</p>
                                    @if($history->note)
                                        <p class="text-stone-500">{{ $history->note }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-stone-500">{{ $history->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    @empty
                        <p class="text-stone-500">No status updates yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Items</p>
                        <h3 class="text-lg font-semibold text-stone-900">Order items</h3>
                    </div>
                    <span class="text-sm text-stone-500">{{ $order->items->count() }} items</span>
                </div>
                <div class="mt-4 space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex flex-wrap items-center justify-between gap-3 text-sm border-b border-stone-100 pb-3">
                            <span class="text-stone-700">{{ $item->product->name ?? 'Product' }} x {{ $item->quantity }}</span>
                            <span class="font-semibold text-stone-800">INR {{ number_format($item->line_total, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg space-y-3">
                @csrf
                @method('PATCH')
                <label class="block text-sm font-medium text-stone-700">Update status</label>
                <select class="w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="status">
                    @foreach(['pending', 'placed', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="rounded-full bg-emerald-600 px-6 py-2 text-white shadow-sm hover:bg-emerald-500" type="submit">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
