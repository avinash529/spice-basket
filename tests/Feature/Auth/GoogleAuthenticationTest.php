<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('services.firebase.api_key', 'firebase-api-key');
        config()->set('services.firebase.auth_domain', 'demo-app.firebaseapp.com');
        config()->set('services.firebase.project_id', 'demo-app');
        config()->set('services.firebase.app_id', '1:1234567890:web:test');
    }

    public function test_firebase_google_sign_in_creates_new_user_and_logs_them_in(): void
    {
        Http::fake([
            'https://identitytoolkit.googleapis.com/*' => Http::response([
                'users' => [[
                    'localId' => 'firebase-user-1',
                    'email' => 'firebase.new@example.com',
                    'displayName' => 'Firebase New User',
                    'photoUrl' => 'https://example.com/firebase-avatar.jpg',
                    'emailVerified' => true,
                    'providerUserInfo' => [
                        ['providerId' => 'google.com'],
                    ],
                ]],
            ], 200),
        ]);

        $response = $this->post(route('auth.google.firebase'), [
            'id_token' => 'firebase-id-token',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('auth.login_method', 'google');
        $this->assertDatabaseHas('users', [
            'email' => 'firebase.new@example.com',
            'google_id' => 'firebase-user-1',
            'google_avatar' => 'https://example.com/firebase-avatar.jpg',
        ]);

        $user = User::query()->where('email', 'firebase.new@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->password);
    }

    public function test_firebase_google_sign_in_links_existing_user_by_email(): void
    {
        $user = User::factory()->create([
            'email' => 'existing@example.com',
            'google_id' => null,
            'google_avatar' => null,
            'email_verified_at' => null,
        ]);

        Http::fake([
            'https://identitytoolkit.googleapis.com/*' => Http::response([
                'users' => [[
                    'localId' => 'firebase-user-2',
                    'email' => 'existing@example.com',
                    'displayName' => 'Existing User',
                    'photoUrl' => 'https://example.com/new-avatar.jpg',
                    'emailVerified' => true,
                    'providerUserInfo' => [
                        ['providerId' => 'google.com'],
                    ],
                ]],
            ], 200),
        ]);

        $response = $this->post(route('auth.google.firebase'), [
            'id_token' => 'firebase-id-token',
        ]);

        $user->refresh();

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertSame('firebase-user-2', $user->google_id);
        $this->assertSame('https://example.com/new-avatar.jpg', $user->google_avatar);
        $this->assertNotNull($user->email_verified_at);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_firebase_google_sign_in_returns_error_if_firebase_is_not_configured(): void
    {
        config()->set('services.firebase.api_key', null);

        Http::fake();

        $response = $this->from(route('login'))->post(route('auth.google.firebase'), [
            'id_token' => 'firebase-id-token',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        Http::assertNothingSent();
    }

    public function test_firebase_google_sign_in_returns_error_for_invalid_id_token(): void
    {
        Http::fake([
            'https://identitytoolkit.googleapis.com/*' => Http::response([
                'error' => [
                    'message' => 'INVALID_ID_TOKEN',
                ],
            ], 400),
        ]);

        $response = $this->from(route('login'))->post(route('auth.google.firebase'), [
            'id_token' => 'invalid-token',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    public function test_firebase_google_sign_in_returns_error_when_email_is_missing(): void
    {
        Http::fake([
            'https://identitytoolkit.googleapis.com/*' => Http::response([
                'users' => [[
                    'localId' => 'firebase-user-3',
                    'displayName' => 'No Email',
                    'emailVerified' => false,
                    'providerUserInfo' => [
                        ['providerId' => 'google.com'],
                    ],
                ]],
            ], 200),
        ]);

        $response = $this->from(route('login'))->post(route('auth.google.firebase'), [
            'id_token' => 'firebase-id-token',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_firebase_google_sign_in_rejects_non_google_provider_token(): void
    {
        Http::fake([
            'https://identitytoolkit.googleapis.com/*' => Http::response([
                'users' => [[
                    'localId' => 'firebase-user-4',
                    'email' => 'password-user@example.com',
                    'displayName' => 'Password User',
                    'emailVerified' => true,
                    'providerUserInfo' => [
                        ['providerId' => 'password'],
                    ],
                ]],
            ], 200),
        ]);

        $response = $this->from(route('login'))->post(route('auth.google.firebase'), [
            'id_token' => 'firebase-id-token',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 0);
    }
}
