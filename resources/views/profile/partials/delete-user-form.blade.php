<section class="space-y-6">
    <header>
        <p class="text-xs uppercase tracking-[0.25em] text-rose-600">{{ __('Danger Zone') }}</p>
        <h2 class="mt-2 text-lg font-semibold text-stone-900">{{ __('Delete Account') }}</h2>
        <p class="mt-1 text-sm text-stone-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        class="rounded-full bg-rose-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500"
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-5 p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-stone-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-sm text-stone-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full rounded-xl border-stone-200 focus:border-rose-400 focus:ring-rose-200 sm:w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <button
                    class="rounded-full border border-stone-200 px-5 py-2 text-sm font-semibold text-stone-700 hover:border-stone-300"
                    type="button"
                    x-on:click="$dispatch('close')"
                >
                    {{ __('Cancel') }}
                </button>

                <button class="rounded-full bg-rose-600 px-5 py-2 text-sm font-semibold text-white hover:bg-rose-500" type="submit">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
