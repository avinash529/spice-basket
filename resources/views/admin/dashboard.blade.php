<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Admin</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <a class="rounded-full border border-emerald-200 bg-white/80 px-4 py-2 text-emerald-700 hover:bg-emerald-50" href="{{ route('admin.categories.index') }}">Categories</a>
                <a class="rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm hover:bg-emerald-500" href="{{ route('admin.products.index') }}">Products</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Products</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-900">{{ $stats['products'] }}</p>
                    <p class="mt-2 text-sm text-stone-600">Active items ready for customers.</p>
                    <a class="mt-4 inline-flex items-center gap-2 text-sm text-emerald-700" href="{{ route('admin.products.index') }}">Manage products</a>
                </div>
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Categories</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-900">{{ $stats['categories'] }}</p>
                    <p class="mt-2 text-sm text-stone-600">Organize the catalog by spice type.</p>
                    <a class="mt-4 inline-flex items-center gap-2 text-sm text-emerald-700" href="{{ route('admin.categories.index') }}">Manage categories</a>
                </div>
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Recent orders</p>
                        <h3 class="text-lg font-semibold text-stone-900">Latest customer orders</h3>
                    </div>
                </div>
                <div class="mt-4 space-y-3 text-sm">
                    @forelse($recentOrders as $order)
                        <div class="flex flex-col gap-2 border-b border-stone-100 pb-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-stone-800">Order #{{ $order->id }}</p>
                                <p class="text-stone-500">{{ $order->user?->name ?? 'Customer' }} · {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-stone-700">
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
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
