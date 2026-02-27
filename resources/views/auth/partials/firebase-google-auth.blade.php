@props([
    'buttonText' => 'Continue with Google',
    'context' => 'auth',
])

@php
    $firebaseConfig = [
        'apiKey' => config('services.firebase.api_key'),
        'authDomain' => config('services.firebase.auth_domain'),
        'projectId' => config('services.firebase.project_id'),
        'storageBucket' => config('services.firebase.storage_bucket'),
        'messagingSenderId' => config('services.firebase.messaging_sender_id'),
        'appId' => config('services.firebase.app_id'),
        'measurementId' => config('services.firebase.measurement_id'),
    ];

    $requiredFirebaseConfig = [
        $firebaseConfig['apiKey'],
        $firebaseConfig['authDomain'],
        $firebaseConfig['projectId'],
        $firebaseConfig['appId'],
    ];

    $firebaseConfigured = collect($requiredFirebaseConfig)->every(
        static fn ($value) => is_string($value) && $value !== ''
    );

    $formId = "firebase-google-form-{$context}";
    $tokenId = "firebase-google-token-{$context}";
    $buttonId = "firebase-google-button-{$context}";
    $buttonLabelId = "firebase-google-label-{$context}";
    $errorId = "firebase-google-error-{$context}";
@endphp

@if ($firebaseConfigured)
    <form id="{{ $formId }}" method="POST" action="{{ route('auth.google.firebase') }}" class="hidden">
        @csrf
        <input type="hidden" name="id_token" id="{{ $tokenId }}">
    </form>

    <button
        type="button"
        id="{{ $buttonId }}"
        class="flex min-h-11 w-full items-center justify-center gap-3 rounded-full border border-stone-300 bg-white px-4 py-3 text-sm font-semibold text-stone-700 transition hover:border-stone-400 hover:bg-stone-50 sm:px-6 disabled:cursor-not-allowed disabled:opacity-70"
    >
        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#EA4335" d="M12 10.3v3.9h5.5c-.2 1.2-1.4 3.6-5.5 3.6-3.3 0-6-2.7-6-6s2.7-6 6-6c1.9 0 3.2.8 4 1.5l2.7-2.6C17 3.1 14.7 2 12 2 6.5 2 2 6.5 2 12s4.5 10 10 10c5.8 0 9.7-4.1 9.7-9.8 0-.7-.1-1.2-.2-1.9H12z"/>
        </svg>
        <span id="{{ $buttonLabelId }}" class="text-center leading-5">{{ $buttonText }}</span>
    </button>
    <p id="{{ $errorId }}" class="mt-2 hidden text-sm text-rose-600"></p>

    <script type="module">
        import { getApp, getApps, initializeApp } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-app.js";
        import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-auth.js";

        const firebaseConfig = @json($firebaseConfig);
        const button = document.getElementById(@json($buttonId));
        const buttonLabel = document.getElementById(@json($buttonLabelId));
        const errorBox = document.getElementById(@json($errorId));
        const form = document.getElementById(@json($formId));
        const tokenInput = document.getElementById(@json($tokenId));

        if (button && buttonLabel && errorBox && form && tokenInput) {
            const app = getApps().length ? getApp() : initializeApp(firebaseConfig);
            const auth = getAuth(app);
            const provider = new GoogleAuthProvider();
            const firebaseErrorMessages = {
                "auth/popup-closed-by-user": "Google sign-in was cancelled before completion.",
                "auth/popup-blocked": "Your browser blocked the Google sign-in popup. Allow popups and try again.",
                "auth/cancelled-popup-request": "A sign-in request is already in progress. Please try again.",
                "auth/unauthorized-domain": "This domain is not authorized in Firebase. Add your app domain in Firebase Authentication settings.",
                "auth/operation-not-allowed": "Google provider is disabled in Firebase Authentication. Enable Google sign-in in Firebase Console.",
                "auth/network-request-failed": "Network error while contacting Google. Check your connection and try again.",
            };

            button.addEventListener("click", async () => {
                const originalLabel = buttonLabel.textContent;

                button.disabled = true;
                buttonLabel.textContent = "Signing in...";
                errorBox.classList.add("hidden");
                errorBox.textContent = "";

                try {
                    const credential = await signInWithPopup(auth, provider);
                    const idToken = await credential.user.getIdToken();

                    tokenInput.value = idToken;
                    form.submit();
                } catch (error) {
                    console.error(error);
                    const message = (error && typeof error.code === "string" && firebaseErrorMessages[error.code])
                        ? firebaseErrorMessages[error.code]
                        : "Google sign-in failed. Please try again.";
                    errorBox.textContent = message;
                    errorBox.classList.remove("hidden");
                    button.disabled = false;
                    buttonLabel.textContent = originalLabel;
                }
            });
        }
    </script>
@else
    <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
        Google sign-in is unavailable until Firebase keys are configured.
    </div>
@endif
