<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Account</p>
            <h2 class="font-semibold text-2xl text-stone-900 leading-tight">{{ __('Profile') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div id="addresses" class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                @include('profile.partials.manage-addresses-form')
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
