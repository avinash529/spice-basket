<x-guest-layout>
    <div class="mx-auto w-full max-w-5xl">
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 sm:hidden">
            <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Spice Basket</p>
            <p class="mt-2 text-sm text-stone-700">Create your account to track orders and manage checkout details.</p>
        </div>

        <div class="grid gap-0 overflow-hidden rounded-2xl border border-stone-100 bg-white/95 shadow-2xl sm:rounded-[2rem] sm:grid-cols-2">
            <div class="relative hidden sm:flex flex-col justify-between bg-gradient-to-br from-amber-500 via-rose-500 to-emerald-500 p-10 text-white lg:p-12">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-white/80">Spice Basket</p>
                    <h1 class="mt-5 text-3xl sm:text-4xl font-semibold leading-tight">Create your account</h1>
                    <p class="mt-4 text-sm text-white/90">Join to track orders and unlock farmer-direct spices.</p>
                </div>
                <div class="rounded-2xl bg-white/15 p-5 text-sm">
                    <p class="font-semibold">Member perks</p>
                    <p class="mt-1 text-white/80">Early access to new harvests and best prices.</p>
                </div>
            </div>

            <div class="p-5 sm:p-10 lg:p-12">
                <div class="flex flex-wrap items-start justify-between gap-3 sm:items-center">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Account</p>
                        <h2 class="mt-2 text-2xl sm:text-3xl font-semibold text-stone-900">Register</h2>
                    </div>
                    <a class="w-full text-sm font-medium text-emerald-700 hover:text-emerald-600 sm:w-auto sm:text-right" href="{{ route('login') }}">Already registered?</a>
                </div>

                <div class="mt-8">
                    @include('auth.partials.firebase-google-auth', [
                        'buttonText' => 'Sign up with Google',
                        'context' => 'register',
                    ])
                </div>

                <div class="my-6 flex items-center gap-3">
                    <span class="h-px flex-1 bg-stone-200"></span>
                    <span class="text-center text-xs uppercase leading-tight tracking-[0.2em] text-stone-400">or register with email</span>
                    <span class="h-px flex-1 bg-stone-200"></span>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="text-sm font-semibold text-stone-700" for="name">Name</label>
                        <input id="name" class="mt-2 w-full rounded-xl border-stone-200 px-4 py-3 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700" for="email">Email</label>
                        <input id="email" class="mt-2 w-full rounded-xl border-stone-200 px-4 py-3 focus:border-emerald-400 focus:ring-emerald-200" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700" for="phone">Phone</label>
                        <input id="phone" class="mt-2 w-full rounded-xl border-stone-200 px-4 py-3 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700" for="password">Password</label>
                        <input id="password" class="mt-2 w-full rounded-xl border-stone-200 px-4 py-3 focus:border-emerald-400 focus:ring-emerald-200" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700" for="password_confirmation">Confirm password</label>
                        <input id="password_confirmation" class="mt-2 w-full rounded-xl border-stone-200 px-4 py-3 focus:border-emerald-400 focus:ring-emerald-200" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button class="w-full rounded-full bg-emerald-600 px-6 py-3 text-white shadow-sm hover:bg-emerald-500" type="submit">
                        Create account
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
