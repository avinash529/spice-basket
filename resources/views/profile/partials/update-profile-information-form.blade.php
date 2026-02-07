<section>
    <header>
        <p class="text-xs uppercase tracking-[0.25em] text-emerald-600">{{ __('Account Details') }}</p>
        <h2 class="mt-2 text-lg font-semibold text-stone-900">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-stone-600">
            {{ __("Update your account's profile information, email, and phone number.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label class="text-sm font-semibold text-stone-700" for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="text-sm font-semibold text-stone-700" for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-stone-700">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="font-semibold text-emerald-700 hover:text-emerald-600">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-emerald-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <label class="text-sm font-semibold text-stone-700" for="phone">{{ __('Phone') }}</label>
            <input id="phone" name="phone" type="text" class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" value="{{ old('phone', $user->phone) }}" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <button class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500" type="submit">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
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
