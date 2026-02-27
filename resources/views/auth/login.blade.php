<x-guest-layout>
    <div class="mx-auto w-full max-w-5xl">
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 sm:hidden">
            <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Spice Basket</p>
            <p class="mt-2 text-sm text-stone-700">Sign in to track orders and manage your account.</p>
        </div>

        <div class="grid gap-0 overflow-hidden rounded-2xl border border-stone-100 bg-white/95 shadow-2xl sm:rounded-[2rem] sm:grid-cols-2">
            <div class="relative hidden sm:flex flex-col justify-between bg-gradient-to-br from-emerald-600 via-emerald-500 to-amber-500 p-10 text-white lg:p-12">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-emerald-100">Spice Basket</p>
                    <h1 class="mt-5 text-3xl sm:text-4xl font-semibold leading-tight">Welcome back</h1>
                    <p class="mt-4 text-sm text-emerald-50">Sign in to manage your orders, saved addresses, and discover fresh spices.</p>
                </div>
                <div class="rounded-2xl bg-white/15 p-5 text-sm">
                    <p class="font-semibold">Fresh. Traceable. Reliable.</p>
                    <p class="mt-1 text-emerald-50">Directly sourced from trusted farmers.</p>
                </div>
            </div>

            <div class="p-5 sm:p-10 lg:p-12">
                <div class="flex flex-wrap items-start justify-between gap-3 sm:items-center">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Account</p>
                        <h2 class="mt-2 text-2xl sm:text-3xl font-semibold text-stone-900">Login</h2>
                    </div>
                    <a class="w-full text-sm font-medium text-emerald-700 hover:text-emerald-600 sm:w-auto sm:text-right" href="{{ route('register') }}">Create account</a>
                </div>

                <x-auth-session-status class="mt-5" :status="session('status')" />

                <div class="mt-8">
                    @include('auth.partials.firebase-google-auth', [
                        'buttonText' => 'Continue with Google',
                        'context' => 'login',
                    ])
                </div>

                <div class="my-6 flex items-center gap-3">
                    <span class="h-px flex-1 bg-stone-200"></span>
                    <span class="text-xs uppercase tracking-[0.2em] text-stone-400">or</span>
                    <span class="h-px flex-1 bg-stone-200"></span>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="text-sm font-semibold text-stone-700" for="email">Email</label>
                        <input id="email" class="mt-2 w-full rounded-xl border-stone-200 px-4 py-3 focus:border-emerald-400 focus:ring-emerald-200" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700" for="password">Password</label>
                        <input id="password" class="mt-2 w-full rounded-xl border-stone-200 px-4 py-3 focus:border-emerald-400 focus:ring-emerald-200" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                        <label for="remember_me" class="inline-flex items-center gap-2 text-stone-600">
                            <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-emerald-600 focus:ring-emerald-200" name="remember">
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-emerald-700 hover:text-emerald-600" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button class="w-full rounded-full bg-emerald-600 px-6 py-3 text-white shadow-sm hover:bg-emerald-500" type="submit">
                        Log in
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
