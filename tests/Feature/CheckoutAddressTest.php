<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_requires_address_owned_by_authenticated_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = $this->createProduct();

        Address::create([
            'user_id' => $user->id,
            'full_name' => 'My Address',
            'phone' => '9876503333',
            'house_street' => 'My street',
            'district' => 'Kozhikode',
            'pincode' => '673001',
            'is_default' => true,
        ]);

        $foreignAddress = Address::create([
            'user_id' => $otherUser->id,
            'full_name' => 'Other User',
            'phone' => '9876501111',
            'house_street' => 'Other street',
            'district' => 'Ernakulam',
            'pincode' => '682001',
            'is_default' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->from(route('checkout.index'))
            ->withSession(['cart' => $this->cartPayload($product)])
            ->post(route('checkout.store'), [
                'address_id' => $foreignAddress->id,
            ]);

        $response->assertRedirect(route('checkout.index'));
        $response->assertSessionHasErrors('address_id');
    }

    public function test_checkout_stores_shipping_address_snapshot(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $address = Address::create([
            'user_id' => $user->id,
            'full_name' => 'Test Customer',
            'phone' => '9876501234',
            'house_street' => 'House 10, Main Road',
            'district' => 'Kozhikode',
            'pincode' => '673001',
            'is_default' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession(['cart' => $this->cartPayload($product)])
            ->post(route('checkout.store'), [
                'address_id' => $address->id,
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'address_id' => $address->id,
            'shipping_full_name' => 'Test Customer',
            'shipping_phone' => '9876501234',
            'shipping_house_street' => 'House 10, Main Road',
            'shipping_district' => 'Kozhikode',
            'shipping_pincode' => '673001',
            'status' => 'placed',
        ]);
    }

    public function test_checkout_creates_address_when_user_has_no_saved_address(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $response = $this
            ->actingAs($user)
            ->withSession(['cart' => $this->cartPayload($product)])
            ->post(route('checkout.store'), [
                'full_name' => 'Fresh Customer',
                'phone' => '9876502222',
                'house_street' => 'House 2, First Street',
                'district' => 'Thrissur',
                'pincode' => '680001',
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'full_name' => 'Fresh Customer',
            'district' => 'Thrissur',
            'pincode' => '680001',
            'is_default' => 1,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'shipping_full_name' => 'Fresh Customer',
            'shipping_district' => 'Thrissur',
            'shipping_pincode' => '680001',
        ]);
    }

    private function createProduct(): Product
    {
        return Product::create([
            'name' => 'Black Pepper',
            'slug' => 'black-pepper',
            'price' => 180,
            'unit' => '100g',
            'stock_qty' => 10,
            'is_active' => true,
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function cartPayload(Product $product): array
    {
        return [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'unit' => $product->unit,
                'image_url' => $product->image_url,
                'quantity' => 1,
            ],
        ];
    }
}
