<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit farmer</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-6 rounded-xl bg-rose-50 p-4 text-rose-700">
                    <p class="font-semibold">Please fix the errors below.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.farmers.update', $farmer) }}" class="rounded-2xl bg-white p-6 shadow-sm space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium">Name</label>
                    <input class="mt-1 w-full rounded-xl border-gray-200" type="text" name="name" value="{{ old('name', $farmer->name) }}" required />
                    @error('name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Location</label>
                    <input class="mt-1 w-full rounded-xl border-gray-200" type="text" name="location" value="{{ old('location', $farmer->location) }}" />
                    @error('location')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium">Phone</label>
                        <input class="mt-1 w-full rounded-xl border-gray-200" type="text" name="phone" value="{{ old('phone', $farmer->phone) }}" />
                        @error('phone')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input class="mt-1 w-full rounded-xl border-gray-200" type="email" name="email" value="{{ old('email', $farmer->email) }}" />
                        @error('email')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Notes</label>
                    <textarea class="mt-1 w-full rounded-xl border-gray-200" name="notes" rows="3">{{ old('notes', $farmer->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $farmer->is_active) ? 'checked' : '' }} />
                    Active
                </label>
                <button class="rounded-full bg-emerald-600 px-6 py-2 text-white" type="submit">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
