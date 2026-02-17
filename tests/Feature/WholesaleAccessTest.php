<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WholesaleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_wholesale_user_can_access_wholesale_portal(): void
    {
        $user = User::factory()->create([
            'role' => 'wholesale',
        ]);

        $response = $this->actingAs($user)->get(route('wholesale.index'));

        $response->assertOk();
    }

    public function test_regular_user_cannot_access_wholesale_portal(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('wholesale.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_wholesale_content(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.wholesale-content.store'), [
            'title' => 'Bulk Buyer Offer',
            'summary' => 'For retailers and distributors.',
            'content' => 'Minimum order quantity starts at 50kg across selected spices.',
            'cta_label' => 'Request Price List',
            'cta_url' => 'https://example.com/wholesale',
            'contact_email' => 'bulk@example.com',
            'contact_phone' => '9999988888',
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.wholesale-content.index'));
        $this->assertDatabaseHas('wholesale_contents', [
            'title' => 'Bulk Buyer Offer',
            'slug' => 'bulk-buyer-offer',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_assign_user_as_wholesale(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'wholesale',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'wholesale',
        ]);
    }
}
