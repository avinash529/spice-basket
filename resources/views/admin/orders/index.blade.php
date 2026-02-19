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
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
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
                                    <a
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-100 text-emerald-700 hover:bg-emerald-50"
                                        href="{{ route('admin.orders.show', $order) }}"
                                        title="View order"
                                        aria-label="View order #{{ $order->id }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M1.173 10a13.133 13.133 0 0 1 1.66-2.043C4.12 6.668 6.07 5.5 8.5 5.5c2.43 0 4.38 1.168 5.667 2.457A13.133 13.133 0 0 1 15.827 10a13.133 13.133 0 0 1-1.66 2.043C12.88 13.332 10.93 14.5 8.5 14.5c-2.43 0-4.38-1.168-5.667-2.457A13.133 13.133 0 0 1 1.173 10ZM8.5 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                        </svg>
                                        <span class="sr-only">View</span>
                                    </a>
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
            </div>
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
