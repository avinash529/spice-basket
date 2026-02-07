<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="rounded-xl bg-emerald-50 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="rounded-xl bg-rose-50 p-4 text-rose-700">
                    <p class="font-semibold">Action failed</p>
                    <p class="text-sm mt-1">{{ $errors->first() }}</p>
                </div>
            @endif

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2">Name</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">Role</th>
                                <th class="py-2">Joined</th>
                                <th class="py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="text-gray-700">
                                    <td class="py-3 font-semibold">{{ $user->name }}</td>
                                    <td class="py-3">{{ $user->email }}</td>
                                    <td class="py-3">
                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold">
                                            {{ ucfirst($user->role ?? 'user') }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $user->created_at?->format('M d, Y') }}</td>
                                    <td class="py-3 text-right space-x-3">
                                        <a class="text-emerald-700" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                                        <form class="inline" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-rose-600" type="submit" onclick="return confirm('Delete this user?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-6 text-gray-500" colspan="5">No users yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
