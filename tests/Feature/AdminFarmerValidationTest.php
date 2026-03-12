<?php

namespace Tests\Feature;

use App\Models\Farmer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFarmerValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_farmer_create_page_is_displayed(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this
            ->actingAs($admin)
            ->get(route('admin.farmers.create'))
            ->assertOk();
    }

    public function test_admin_farmer_creation_rejects_invalid_fields(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->from(route('admin.farmers.create'))
            ->post(route('admin.farmers.store'), [
                'name' => '',
                'email' => 'not-an-email',
            ]);

        $response
            ->assertRedirect(route('admin.farmers.create'))
            ->assertSessionHasErrors(['name', 'email']);

        $this->assertDatabaseCount('farmers', 0);
    }

    public function test_admin_farmer_can_be_updated(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $farmer = Farmer::query()->create([
            'name' => 'Old Farmer',
            'is_active' => true,
        ]);

        $this
            ->actingAs($admin)
            ->put(route('admin.farmers.update', $farmer), [
                'name' => 'Updated Farmer',
                'location' => 'Idukki',
                'phone' => '9876501234',
                'email' => 'farmer@example.com',
                'notes' => 'Primary supplier',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.farmers.index'));

        $this->assertDatabaseHas('farmers', [
            'id' => $farmer->id,
            'name' => 'Updated Farmer',
            'location' => 'Idukki',
            'phone' => '9876501234',
            'email' => 'farmer@example.com',
            'notes' => 'Primary supplier',
            'is_active' => true,
        ]);
    }
}
