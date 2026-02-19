<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Catalog</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Categories</h2>
            </div>
            <a class="rounded-full bg-emerald-600 px-5 py-2 text-white shadow-sm hover:bg-emerald-500" href="{{ route('admin.categories.create') }}">Add category</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif
            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                    <thead class="text-left text-stone-500">
                        <tr>
                            <th class="py-2">Name</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($categories as $category)
                            <tr class="text-stone-700">
                                <td class="py-4 font-semibold">{{ $category->name }}</td>
                                <td class="py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-600' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center gap-2">
                                        <a
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-100 text-emerald-700 hover:bg-emerald-50"
                                            href="{{ route('admin.products.create', ['category_id' => $category->id]) }}"
                                            title="Add product"
                                            aria-label="Add product in {{ $category->name }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 3.25a.75.75 0 0 1 .75.75v5.25H16a.75.75 0 0 1 0 1.5h-5.25V16a.75.75 0 0 1-1.5 0v-5.25H4a.75.75 0 0 1 0-1.5h5.25V4a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Add product</span>
                                        </a>
                                        <a
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-100 text-emerald-700 hover:bg-emerald-50"
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            title="Edit category"
                                            aria-label="Edit {{ $category->name }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M17.414 2.586a2 2 0 0 0-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 0 0 0-2.828Z" />
                                                <path fill-rule="evenodd" d="M2 15.25A2.75 2.75 0 0 1 4.75 12.5H6v2.25A2.75 2.75 0 0 1 3.25 17.5H2v-2.25Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                        <form class="inline-flex" method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-rose-100 text-rose-600 hover:bg-rose-50"
                                                type="submit"
                                                onclick="return confirm('Delete this category?')"
                                                title="Delete category"
                                                aria-label="Delete {{ $category->name }}"
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
                                <td class="py-6 text-stone-500" colspan="3">No categories yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
