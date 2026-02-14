<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminProductFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_create_redirects_to_category_creation_when_no_categories_exist(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('admin.products.create'));

        $response->assertRedirect(route('admin.categories.create'));
    }

    public function test_product_create_can_be_opened_without_category_query_param(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $firstCategory = $this->createCategory('A Spices');
        $this->createCategory('Z Spices');

        $response = $this
            ->actingAs($admin)
            ->get(route('admin.products.create'));

        $response->assertOk();
        $response->assertSee('name="category_id"', false);
        $response->assertSee('value="'.$firstCategory->id.'" selected', false);
    }

    public function test_duplicate_product_name_gets_unique_slug_on_store(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $category = $this->createCategory('Whole Spices');

        Product::create([
            'name' => 'Black Pepper Whole',
            'slug' => 'black-pepper-whole',
            'description' => 'Original listing',
            'price' => 200,
            'unit' => '100g',
            'stock_qty' => 25,
            'origin' => 'Wayanad',
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Black Pepper Whole',
                'description' => 'Second listing',
                'price' => '210',
                'unit' => '100g',
                'stock_qty' => 30,
                'origin' => 'Idukki',
                'category_id' => $category->id,
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'slug' => 'black-pepper-whole-2',
            'category_id' => $category->id,
        ]);
    }

    public function test_admin_can_store_festival_offer_configuration_for_product(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $category = $this->createCategory('Festive Spices');

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Onam Pepper Mix',
                'description' => 'Seasonal special blend',
                'price' => '350',
                'unit' => '250g',
                'stock_qty' => 20,
                'origin' => 'Kerala',
                'category_id' => $category->id,
                'offer_mode' => 'onam',
                'normal_offer_percent' => '5',
                'vishu_offer_percent' => '8',
                'onam_offer_percent' => '15',
                'christmas_offer_percent' => '12',
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Onam Pepper Mix',
            'offer_mode' => 'onam',
            'normal_offer_percent' => 5,
            'vishu_offer_percent' => 8,
            'onam_offer_percent' => 15,
            'christmas_offer_percent' => 12,
        ]);
    }

    private function createCategory(string $name): Category
    {
        return Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => true,
        ]);
    }
}
