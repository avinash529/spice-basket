<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Admin</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Wholesale Content</h2>
            </div>
            <a class="rounded-full bg-emerald-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-emerald-500" href="{{ route('admin.wholesale-content.create') }}">
                Add content
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-stone-500">
                            <tr>
                                <th class="py-2">Title</th>
                                <th class="py-2">Slug</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Order</th>
                                <th class="py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($contents as $content)
                                <tr class="text-stone-700">
                                    <td class="py-3 font-semibold">{{ $content->title }}</td>
                                    <td class="py-3">{{ $content->slug }}</td>
                                    <td class="py-3">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $content->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-600' }}">
                                            {{ $content->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $content->sort_order }}</td>
                                    <td class="py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a class="rounded-full border border-emerald-200 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50" href="{{ route('admin.wholesale-content.edit', $content) }}">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.wholesale-content.destroy', $content) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="rounded-full border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50"
                                                    type="submit"
                                                    onclick="return confirm('Delete this wholesale content item?')"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-6 text-stone-500" colspan="5">No wholesale content created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                {{ $contents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
