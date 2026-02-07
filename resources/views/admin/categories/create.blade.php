<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Catalog</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Add category</h2>
            </div>
            <a class="text-sm text-emerald-700" href="{{ route('admin.categories.index') }}">Back to categories</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-3xl border border-emerald-100 bg-emerald-50/70 p-5 text-sm text-emerald-700">
                Create a category first, then add products under it.
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700">Name</label>
                    <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="name" value="{{ old('name') }}" required />
                    @error('name')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Description</label>
                    <textarea class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" checked />
                    Active
                </label>
                <div class="flex items-center gap-4">
                    <button class="rounded-full bg-emerald-600 px-6 py-2 text-white shadow-sm hover:bg-emerald-500" type="submit">Save</button>
                    <a class="text-sm text-stone-600" href="{{ route('admin.categories.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
