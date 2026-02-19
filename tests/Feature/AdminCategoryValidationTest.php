<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_category_creation_rejects_empty_name(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), [
                'name' => '',
                'description' => 'Sample description',
            ]);

        $response
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 0);
    }

    public function test_symbol_only_category_name_gets_non_empty_unique_slug(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this
            ->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => '###',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $this
            ->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => '***',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => '###',
            'slug' => 'category',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => '***',
            'slug' => 'category-2',
        ]);
    }
}

