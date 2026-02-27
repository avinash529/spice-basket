<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class GoogleAuthController extends Controller
{
    public function firebase(Request $request): RedirectResponse
    {
        $request->validate([
            'id_token' => ['required', 'string'],
        ]);

        $apiKey = config('services.firebase.api_key');

        if (blank($apiKey)) {
            throw ValidationException::withMessages([
                'email' => 'Firebase Google sign-in is not configured. Set FIREBASE_API_KEY in .env and run php artisan config:clear.',
            ]);
        }

        $firebaseUser = $this->fetchFirebaseUser(
            $request->string('id_token')->toString(),
            $apiKey
        );

        $firebaseUid = $firebaseUser['localId'] ?? null;
        $email = $firebaseUser['email'] ?? null;
        $providerUserInfo = $firebaseUser['providerUserInfo'] ?? [];

        if (! is_string($firebaseUid) || $firebaseUid === '' || ! is_string($email) || $email === '') {
            throw ValidationException::withMessages([
                'email' => 'Google sign-in failed. Missing account details from Firebase.',
            ]);
        }

        $isGoogleLinked = collect($providerUserInfo)->contains(
            static fn ($provider) => is_array($provider) && ($provider['providerId'] ?? null) === 'google.com'
        );

        if (! $isGoogleLinked) {
            throw ValidationException::withMessages([
                'email' => 'Google sign-in failed. Firebase account is not linked to Google.',
            ]);
        }

        $user = User::query()
            ->where('google_id', $firebaseUid)
            ->first();

        if (! $user) {
            $user = User::query()
                ->where('email', $email)
                ->first();
        }

        $avatar = is_string($firebaseUser['photoUrl'] ?? null) && $firebaseUser['photoUrl'] !== ''
            ? $firebaseUser['photoUrl']
            : null;

        $displayName = is_string($firebaseUser['displayName'] ?? null) && trim($firebaseUser['displayName']) !== ''
            ? trim($firebaseUser['displayName'])
            : null;

        $isEmailVerified = filter_var($firebaseUser['emailVerified'] ?? false, FILTER_VALIDATE_BOOL);

        if ($user) {
            $updates = [];

            if ($user->google_id !== $firebaseUid) {
                $updates['google_id'] = $firebaseUid;
            }

            if ($avatar) {
                $updates['google_avatar'] = $avatar;
            }

            if ($displayName && $user->name === 'Google User') {
                $updates['name'] = $displayName;
            }

            if (! $user->email_verified_at && $isEmailVerified) {
                $updates['email_verified_at'] = now();
            }

            if ($updates !== []) {
                $user->forceFill($updates)->save();
            }
        } else {
            $user = User::create([
                'name' => $displayName ?: 'Google User',
                'email' => $email,
                'google_id' => $firebaseUid,
                'google_avatar' => $avatar,
                'email_verified_at' => $isEmailVerified ? now() : null,
                'password' => null,
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('auth.login_method', 'google');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    private function fetchFirebaseUser(string $idToken, string $apiKey): array
    {
        $response = Http::asJson()->post(
            "https://identitytoolkit.googleapis.com/v1/accounts:lookup?key={$apiKey}",
            ['idToken' => $idToken]
        );

        if ($response->failed()) {
            throw ValidationException::withMessages([
                'email' => 'Google sign-in failed. Firebase rejected the token.',
            ]);
        }

        $firebaseUser = $response->json('users.0');

        if (! is_array($firebaseUser)) {
            throw ValidationException::withMessages([
                'email' => 'Google sign-in failed. Firebase did not return a user profile.',
            ]);
        }

        return $firebaseUser;
    }
}
