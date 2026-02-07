<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Farmers</h2>
            <a class="rounded-full bg-emerald-600 px-4 py-2 text-white" href="{{ route('admin.farmers.create') }}">Add farmer</a>
        </div>
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
                            <th class="py-2">Name</th>
                            <th class="py-2">Location</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($farmers as $farmer)
                            <tr class="border-t">
                                <td class="py-3">{{ $farmer->name }}</td>
                                <td class="py-3">{{ $farmer->location }}</td>
                                <td class="py-3">{{ $farmer->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="py-3 space-x-3">
                                    <a class="text-emerald-700" href="{{ route('admin.farmers.edit', $farmer) }}">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('admin.farmers.destroy', $farmer) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-600" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4 text-gray-500" colspan="4">No farmers yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $farmers->links() }}
        </div>
    </div>
</x-app-layout>
