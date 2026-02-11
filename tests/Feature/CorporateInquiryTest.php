<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorporateInquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_corporate_inquiry_can_be_submitted(): void
    {
        $payload = [
            'name' => 'Priya Menon',
            'email' => 'priya@example.com',
            'phone' => '9876543210',
            'company' => 'Spice Events LLP',
            'message' => 'Need 200 gift boxes for a client event in Kochi next month.',
        ];

        $response = $this->post(route('corporate-gifts.inquiry'), $payload);

        $response
            ->assertRedirect(route('corporate-gifts.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('corporate_inquiries', [
            'name' => 'Priya Menon',
            'email' => 'priya@example.com',
            'phone' => '9876543210',
            'company' => 'Spice Events LLP',
        ]);
    }

    public function test_corporate_inquiry_requires_required_fields(): void
    {
        $response = $this->post(route('corporate-gifts.inquiry'), []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'message']);
        $this->assertDatabaseCount('corporate_inquiries', 0);
    }
}

