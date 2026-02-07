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
                <table class="w-full text-sm">
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
                                <td class="py-4 space-x-3">
                                    <a class="text-emerald-700" href="{{ route('admin.products.create', ['category_id' => $category->id]) }}">Add product</a>
                                    <a class="text-emerald-700" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-600" type="submit" onclick="return confirm('Delete this category?')">Delete</button>
                                    </form>
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
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
