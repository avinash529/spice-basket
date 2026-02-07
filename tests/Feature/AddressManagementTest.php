<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_valid_address(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('addresses.store'), $this->validAddressPayload());

        $response->assertRedirect(route('profile.edit').'#addresses');
        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'district' => 'Kozhikode',
            'pincode' => '673001',
        ]);
    }

    public function test_address_requires_kerala_district_pincode_and_phone(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('profile.edit'))
            ->post(route('addresses.store'), [
                'full_name' => 'Test User',
                'phone' => '12345',
                'house_street' => 'House No 10, Main Street',
                'district' => 'Chennai',
                'pincode' => '600001',
            ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrorsIn('address', ['phone', 'district', 'pincode']);
    }

    public function test_user_cannot_add_more_than_five_addresses(): void
    {
        $user = User::factory()->create();

        for ($i = 1; $i <= 5; $i++) {
            $user->addresses()->create([
                'full_name' => "Test User {$i}",
                'phone' => '98765012'.str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'house_street' => "House {$i}, Main Road",
                'district' => 'Kozhikode',
                'pincode' => '673001',
                'is_default' => $i === 1,
            ]);
        }

        $response = $this
            ->actingAs($user)
            ->from(route('profile.edit'))
            ->post(route('addresses.store'), $this->validAddressPayload([
                'full_name' => 'Overflow User',
                'phone' => '9876509999',
            ]));

        $response->assertRedirect(route('profile.edit').'#addresses');
        $response->assertSessionHasErrorsIn('address', 'address_limit');
        $this->assertSame(5, $user->addresses()->count());
    }

    public function test_user_cannot_edit_another_users_address(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $address = Address::create([
            'user_id' => $otherUser->id,
            'full_name' => 'Other User',
            'phone' => '9876504321',
            'house_street' => 'Other House',
            'district' => 'Kollam',
            'pincode' => '691001',
            'is_default' => true,
        ]);

        $this
            ->actingAs($user)
            ->patch(route('addresses.update', $address), $this->validAddressPayload())
            ->assertNotFound();
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private function validAddressPayload(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Test User',
            'phone' => '9876501234',
            'house_street' => 'House No 10, Main Street',
            'district' => 'Kozhikode',
            'pincode' => '673001',
            'is_default' => 1,
        ], $overrides);
    }
}
