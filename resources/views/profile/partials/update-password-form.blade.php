<section>
    @php($profileUser = $user ?? auth()->user())
    @php($signedInViaGoogle = session('auth.login_method') === 'google')
    @php($requiresCurrentPassword = filled($profileUser?->password) && ! ($signedInViaGoogle && filled($profileUser?->google_id)))

    <header>
        <p class="text-xs uppercase tracking-[0.25em] text-emerald-600">{{ __('Security') }}</p>
        <h2 class="mt-2 text-lg font-semibold text-stone-900">
            {{ $requiresCurrentPassword ? __('Update Password') : __('Set Password') }}
        </h2>
        <p class="mt-1 text-sm text-stone-600">
            {{ $requiresCurrentPassword
                ? __('Ensure your account is using a long, random password to stay secure.')
                : __('Add a password so you can sign in with email and password too.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        @if ($requiresCurrentPassword)
            <div>
                <label class="text-sm font-semibold text-stone-700" for="update_password_current_password">{{ __('Current Password') }}</label>
                <input id="update_password_current_password" name="current_password" type="password" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
        @endif

        <div>
            <label class="text-sm font-semibold text-stone-700" for="update_password_password">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="text-sm font-semibold text-stone-700" for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500" type="submit">
                {{ __('Save Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-700"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
