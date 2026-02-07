<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Profile</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Edit Address</h2>
            </div>
            <a class="text-sm text-emerald-700 hover:text-emerald-600" href="{{ route('addresses.index') }}">Back to addresses</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg" method="POST" action="{{ route('addresses.update', $address) }}">
                @csrf
                @method('PATCH')
                @php($submitLabel = 'Update address')
                @include('addresses.partials.form')
            </form>
        </div>
    </div>
</x-app-layout>
