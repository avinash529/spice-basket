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
                                <td class="py-3">
                                    <div class="flex items-center gap-2">
                                        <a
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-100 text-emerald-700 hover:bg-emerald-50"
                                            href="{{ route('admin.farmers.edit', $farmer) }}"
                                            title="Edit farmer"
                                            aria-label="Edit {{ $farmer->name }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M17.414 2.586a2 2 0 0 0-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 0 0 0-2.828Z" />
                                                <path fill-rule="evenodd" d="M2 15.25A2.75 2.75 0 0 1 4.75 12.5H6v2.25A2.75 2.75 0 0 1 3.25 17.5H2v-2.25Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                        <form class="inline-flex" method="POST" action="{{ route('admin.farmers.destroy', $farmer) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-rose-100 text-rose-600 hover:bg-rose-50"
                                                type="submit"
                                                onclick="return confirm('Delete this farmer?')"
                                                title="Delete farmer"
                                                aria-label="Delete {{ $farmer->name }}"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M8.75 2.5a.75.75 0 0 0-.75.75V4h4V3.25a.75.75 0 0 0-.75-.75h-2.5ZM13.5 4V3.25A2.25 2.25 0 0 0 11.25 1h-2.5A2.25 2.25 0 0 0 6.5 3.25V4H4.75a.75.75 0 0 0 0 1.5h.438l.652 10.427A2.25 2.25 0 0 0 8.086 18h3.828a2.25 2.25 0 0 0 2.246-2.073L14.812 5.5h.438a.75.75 0 0 0 0-1.5H13.5Zm-4.75 4a.75.75 0 0 1 .75.75v5a.75.75 0 0 1-1.5 0v-5A.75.75 0 0 1 8.75 8Zm3.25.75a.75.75 0 0 0-1.5 0v5a.75.75 0 0 0 1.5 0v-5Z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="sr-only">Delete</span>
                                            </button>
                                        </form>
                                    </div>
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
