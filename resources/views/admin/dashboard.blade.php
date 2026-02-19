<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Admin</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a class="rounded-full border border-emerald-200 bg-white/80 px-4 py-2 text-emerald-700 hover:bg-emerald-50" href="{{ route('admin.orders.index') }}">Orders</a>
                <a class="rounded-full border border-emerald-200 bg-white/80 px-4 py-2 text-emerald-700 hover:bg-emerald-50" href="{{ route('admin.users.index') }}">Users</a>
                <a class="rounded-full border border-emerald-200 bg-white/80 px-4 py-2 text-emerald-700 hover:bg-emerald-50" href="{{ route('admin.categories.index') }}">Categories</a>
                <a class="rounded-full border border-emerald-200 bg-white/80 px-4 py-2 text-emerald-700 hover:bg-emerald-50" href="{{ route('admin.wholesale-content.index') }}">Wholesale Content</a>
                <a class="rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm hover:bg-emerald-500" href="{{ route('admin.products.index') }}">Products</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif

            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Total revenue</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-900">INR {{ number_format($stats['revenue_total'], 2) }}</p>
                    <p class="mt-2 text-sm text-stone-600">Today: INR {{ number_format($stats['revenue_today'], 2) }}</p>
                </div>
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">This month</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-900">INR {{ number_format($stats['revenue_month'], 2) }}</p>
                    <p class="mt-2 text-sm text-stone-600">AOV: INR {{ number_format($stats['average_order_value'], 2) }}</p>
                </div>
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Orders</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-900">{{ $stats['orders_total'] }}</p>
                    <p class="mt-2 text-sm text-stone-600">{{ $stats['orders_pending'] }} need fulfillment</p>
                    <a class="mt-4 inline-flex items-center gap-2 text-sm text-emerald-700" href="{{ route('admin.orders.index') }}">Manage orders</a>
                </div>
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Customers</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-900">{{ $stats['customers_total'] }}</p>
                    <p class="mt-2 text-sm text-stone-600">{{ $stats['products_active'] }} active products</p>
                </div>
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Catalog</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-900">{{ $stats['products_total'] }}</p>
                    <p class="mt-2 text-sm text-stone-600">{{ $stats['categories_total'] }} categories</p>
                </div>
                <div class="rounded-3xl border border-amber-200 bg-amber-50/70 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-amber-700">Low stock</p>
                    <p class="mt-3 text-3xl font-semibold text-amber-900">{{ $stats['low_stock_count'] }}</p>
                    <p class="mt-2 text-sm text-amber-800">Items with stock between 1 and {{ $lowStockThreshold }}</p>
                </div>
                <div class="rounded-3xl border border-rose-200 bg-rose-50/70 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-rose-700">Out of stock</p>
                    <p class="mt-3 text-3xl font-semibold text-rose-900">{{ $stats['out_of_stock_count'] }}</p>
                    <p class="mt-2 text-sm text-rose-800">Active items unavailable for sale</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg lg:col-span-2">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-stone-500">7-day trend</p>
                            <h3 class="text-lg font-semibold text-stone-900">Sales performance</h3>
                        </div>
                    </div>
                    @php
                        $maxTrendRevenue = max($salesTrend->max('revenue') ?? 0, 1);
                    @endphp
                    <div class="mt-5 space-y-3">
                        @foreach($salesTrend as $point)
                            @php
                                $width = round(($point['revenue'] / $maxTrendRevenue) * 100);
                            @endphp
                            <div class="grid grid-cols-12 items-center gap-3 text-sm">
                                <p class="col-span-2 font-medium text-stone-700">{{ $point['label'] }}</p>
                                <div class="col-span-6 h-2 rounded-full bg-stone-100">
                                    <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $width }}%"></div>
                                </div>
                                <p class="col-span-2 text-stone-600">{{ $point['orders'] }} orders</p>
                                <p class="col-span-2 text-right font-semibold text-stone-800">INR {{ number_format($point['revenue'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Order status</p>
                    <h3 class="text-lg font-semibold text-stone-900">Current distribution</h3>
                    <div class="mt-4 space-y-3">
                        @forelse($statusBreakdown as $status)
                            @php
                                $statusClass = match ($status->status) {
                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                    'cancelled' => 'bg-rose-50 text-rose-700',
                                    'shipped' => 'bg-sky-50 text-sky-700',
                                    default => 'bg-amber-50 text-amber-700',
                                };
                            @endphp
                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-stone-100 px-3 py-2">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ ucfirst($status->status) }}
                                </span>
                                <span class="font-semibold text-stone-800">{{ $status->total }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-stone-500">No order data yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg lg:col-span-2">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Top products</p>
                            <h3 class="text-lg font-semibold text-stone-900">Best sellers by quantity</h3>
                        </div>
                        <a class="text-sm text-emerald-700" href="{{ route('admin.products.index') }}">View catalog</a>
                    </div>
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-left text-stone-500">
                                <tr>
                                    <th class="py-2">Product</th>
                                    <th class="py-2">Units sold</th>
                                    <th class="py-2 text-right">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                @forelse($topProducts as $item)
                                    <tr class="text-stone-700">
                                        <td class="py-3 font-medium">{{ $item->product?->name ?? 'Deleted product' }}</td>
                                        <td class="py-3">{{ (int) $item->total_quantity }}</td>
                                        <td class="py-3 text-right font-semibold">INR {{ number_format((float) $item->total_revenue, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-3 text-stone-500" colspan="3">No sales data yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Inventory alerts</p>
                    <h3 class="text-lg font-semibold text-stone-900">Needs restock</h3>
                    <div class="mt-4 space-y-3">
                        @forelse($stockAlerts as $product)
                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-stone-100 px-3 py-2 text-sm">
                                <p class="font-medium text-stone-800">{{ $product->name }}</p>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $product->stock_qty === 0 ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $product->stock_qty }} {{ $product->unit }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-stone-500">No low-stock items currently.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Recent orders</p>
                        <h3 class="text-lg font-semibold text-stone-900">Latest customer orders</h3>
                    </div>
                    <a class="text-sm text-emerald-700" href="{{ route('admin.orders.index') }}">View all</a>
                </div>
                <div class="mt-4 space-y-3 text-sm">
                    @forelse($recentOrders as $order)
                        @php
                            $orderStatusClass = match ($order->status) {
                                'completed' => 'bg-emerald-50 text-emerald-700',
                                'cancelled' => 'bg-rose-50 text-rose-700',
                                'shipped' => 'bg-sky-50 text-sky-700',
                                default => 'bg-amber-50 text-amber-700',
                            };
                        @endphp
                        <div class="flex flex-col gap-2 border-b border-stone-100 pb-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-stone-800">Order #{{ $order->id }}</p>
                                <p class="text-stone-500">{{ $order->user?->name ?? 'Customer' }} - {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-stone-700">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $orderStatusClass }}">
                                    {{ ucfirst($order->status ?? 'pending') }}
                                </span>
                                <span class="ml-3 font-semibold">INR {{ number_format($order->total, 2) }}</span>
                                <a class="ml-3 text-sm text-emerald-700" href="{{ route('admin.orders.show', $order) }}">View</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-stone-500">No orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
