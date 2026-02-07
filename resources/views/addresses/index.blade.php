<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Profile</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">My Addresses</h2>
            </div>
            @if($addresses->count() < $maxAddresses)
                <a class="rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500" href="{{ route('addresses.create') }}">
                    Add address
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif

            @if($errors->has('address_limit'))
                <div class="rounded-2xl border border-rose-100 bg-rose-50/70 p-4 text-rose-700">{{ $errors->first('address_limit') }}</div>
            @endif

            <div class="rounded-2xl border border-stone-100 bg-white/90 p-4 text-sm text-stone-600 shadow-sm">
                {{ $addresses->count() }} / {{ $maxAddresses }} saved addresses
            </div>

            @forelse($addresses as $address)
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="text-sm text-stone-700">
                            <div class="flex items-center gap-2">
                                <p class="text-base font-semibold text-stone-900">{{ $address->full_name }}</p>
                                @if($address->is_default)
                                    <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Default</span>
                                @endif
                            </div>
                            <p class="mt-1">{{ $address->phone }}</p>
                            <p class="mt-2 whitespace-pre-line">{{ $address->house_street }}</p>
                            <p class="mt-1">{{ $address->district }} - {{ $address->pincode }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a class="rounded-full border border-stone-200 px-4 py-2 text-xs font-semibold text-stone-700 hover:border-emerald-200 hover:text-emerald-700" href="{{ route('addresses.edit', $address) }}">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('addresses.destroy', $address) }}">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50" type="submit">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-stone-100 bg-white/90 p-8 text-center shadow-lg">
                    <p class="text-stone-600">No saved addresses yet.</p>
                    <a class="mt-4 inline-flex rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500" href="{{ route('addresses.create') }}">
                        Add your first address
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
