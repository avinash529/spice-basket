<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add farmer</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.farmers.store') }}" class="rounded-2xl bg-white p-6 shadow-sm space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Name</label>
                    <input class="mt-1 w-full rounded-xl border-gray-200" type="text" name="name" value="{{ old('name') }}" required />
                </div>
                <div>
                    <label class="block text-sm font-medium">Location</label>
                    <input class="mt-1 w-full rounded-xl border-gray-200" type="text" name="location" value="{{ old('location') }}" />
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium">Phone</label>
                        <input class="mt-1 w-full rounded-xl border-gray-200" type="text" name="phone" value="{{ old('phone') }}" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input class="mt-1 w-full rounded-xl border-gray-200" type="email" name="email" value="{{ old('email') }}" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Notes</label>
                    <textarea class="mt-1 w-full rounded-xl border-gray-200" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" checked />
                    Active
                </label>
                <button class="rounded-full bg-emerald-600 px-6 py-2 text-white" type="submit">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
