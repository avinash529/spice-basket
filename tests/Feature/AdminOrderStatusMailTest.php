<?php

namespace Tests\Feature;

use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminOrderStatusMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_status_update_sends_mail_to_customer(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $customer = User::factory()->create();

        $order = Order::create([
            'user_id' => $customer->id,
            'status' => 'placed',
            'subtotal' => 500,
            'total' => 500,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.orders.update', $order), [
                'status' => 'processing',
            ]);

        $response->assertRedirect(route('admin.orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
        ]);

        Mail::assertSent(OrderStatusUpdatedMail::class, function (OrderStatusUpdatedMail $mail) use ($customer, $order) {
            return $mail->hasTo($customer->email)
                && $mail->order->id === $order->id
                && $mail->previousStatus === 'placed'
                && $mail->currentStatus === 'processing';
        });
    }

    public function test_admin_status_update_does_not_send_mail_when_status_is_unchanged(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $customer = User::factory()->create();

        $order = Order::create([
            'user_id' => $customer->id,
            'status' => 'placed',
            'subtotal' => 500,
            'total' => 500,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.orders.update', $order), [
                'status' => 'placed',
            ]);

        $response->assertRedirect(route('admin.orders.show', $order));

        Mail::assertNotSent(OrderStatusUpdatedMail::class);
    }

    public function test_admin_status_update_rejects_invalid_status_value(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $customer = User::factory()->create();

        $order = Order::create([
            'user_id' => $customer->id,
            'status' => 'placed',
            'subtotal' => 500,
            'total' => 500,
        ]);

        $response = $this
            ->actingAs($admin)
            ->from(route('admin.orders.show', $order))
            ->patch(route('admin.orders.update', $order), [
                'status' => 'invalid-status',
            ]);

        $response
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHasErrors('status');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'placed',
        ]);

        Mail::assertNotSent(OrderStatusUpdatedMail::class);
    }
}
