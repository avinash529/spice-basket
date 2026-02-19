<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Admin</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Edit Wholesale Content</h2>
            </div>
            <a class="text-sm text-emerald-700 hover:text-emerald-600" href="{{ route('admin.wholesale-content.index') }}">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.wholesale-content.update', $wholesaleContent) }}" class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg space-y-5">
                @csrf
                @method('PUT')
                @include('admin.wholesale-content.partials.form')

                <div class="flex items-center gap-3">
                    <button class="rounded-full bg-emerald-600 px-5 py-2 text-white shadow-sm hover:bg-emerald-500" type="submit">Save changes</button>
                    <a class="text-sm text-stone-600 hover:text-stone-900" href="{{ route('admin.wholesale-content.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
