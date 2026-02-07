<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartWeightSelectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_shows_weight_dropdown_when_weights_are_available(): void
    {
        $product = $this->createProduct('100g,250g,500g');

        $response = $this->get(route('products.show', $product->slug));

        $response->assertOk();
        $response->assertSee('name="selected_weight"', false);
        $response->assertSee('250g');
    }

    public function test_selected_weight_is_saved_in_cart_line_item(): void
    {
        $product = $this->createProduct('100g,250g,500g');

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 2,
            'selected_weight' => '250g',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart', function (array $cart): bool {
            if (count($cart) !== 1) {
                return false;
            }

            $line = collect($cart)->first();

            return (string) ($line['unit'] ?? '') === '250g'
                && (int) ($line['quantity'] ?? 0) === 2;
        });
    }

    public function test_same_product_with_different_weights_creates_separate_cart_lines(): void
    {
        $product = $this->createProduct('100g,250g');

        $this->post(route('cart.add', $product), [
            'quantity' => 1,
            'selected_weight' => '100g',
        ])->assertRedirect(route('cart.index'));

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 1,
            'selected_weight' => '250g',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart', fn (array $cart): bool => count($cart) === 2);
    }

    public function test_invalid_weight_selection_is_rejected(): void
    {
        $product = $this->createProduct('100g,250g');

        $response = $this
            ->from(route('products.show', $product->slug))
            ->post(route('cart.add', $product), [
                'quantity' => 1,
                'selected_weight' => '1kg',
            ]);

        $response->assertRedirect(route('products.show', $product->slug));
        $response->assertSessionHasErrors('selected_weight');
    }

    public function test_weight_specific_price_is_saved_when_variant_has_price(): void
    {
        $product = $this->createProduct('100g=120,250g=280', 120);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 2,
            'selected_weight' => '250g',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart', function (array $cart): bool {
            $line = collect($cart)->first();

            return (float) ($line['price'] ?? 0) === 280.0
                && (int) ($line['quantity'] ?? 0) === 2;
        });
    }

    public function test_weight_without_price_uses_base_product_price(): void
    {
        $product = $this->createProduct('100g,250g', 120);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 1,
            'selected_weight' => '250g',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart', function (array $cart): bool {
            $line = collect($cart)->first();

            return (float) ($line['price'] ?? 0) === 120.0;
        });
    }

    public function test_json_weight_map_works_for_price_lookup(): void
    {
        $product = $this->createProduct('{"100g":120,"250g":280}', 120);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 1,
            'selected_weight' => '250g',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart', function (array $cart): bool {
            $line = collect($cart)->first();

            return (float) ($line['price'] ?? 0) === 280.0
                && (string) ($line['unit'] ?? '') === '250g';
        });
    }

    private function createProduct(?string $weight, float $price = 120): Product
    {
        return Product::create([
            'name' => 'Test Spice',
            'slug' => 'test-spice-'.uniqid(),
            'price' => $price,
            'unit' => '100g',
            'stock_qty' => 50,
            'weight' => $weight,
            'is_active' => true,
        ]);
    }
}
