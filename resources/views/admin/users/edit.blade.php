<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($errors->any())
                <div class="rounded-xl bg-rose-50 p-4 text-rose-700">
                    <p class="font-semibold">Please fix the errors below.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="rounded-2xl bg-white p-6 shadow-sm space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-2 w-full rounded-xl border-gray-200" />
                    @error('name')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-2 w-full rounded-xl border-gray-200" />
                    @error('email')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold">Role</label>
                    <select name="role" class="mt-2 w-full rounded-xl border-gray-200">
                        <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button class="rounded-full bg-emerald-600 px-5 py-2 text-white" type="submit">Save changes</button>
                    <a class="text-gray-600" href="{{ route('admin.users.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
