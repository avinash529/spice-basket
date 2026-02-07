<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Orders</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('status'))
                <div class="rounded-xl bg-emerald-50 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="py-2">Order</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="border-t">
                                <td class="py-3">#{{ $order->id }}</td>
                                <td class="py-3">{{ $order->user->name ?? 'Customer' }}</td>
                                <td class="py-3">{{ ucfirst($order->status) }}</td>
                                <td class="py-3">INR {{ number_format($order->total, 2) }}</td>
                                <td class="py-3">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-3">
                                    <a class="text-emerald-700" href="{{ route('admin.orders.show', $order) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4 text-gray-500" colspan="6">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
