<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketing_pages_are_accessible(): void
    {
        $routes = [
            'spices.guide',
            'offers.index',
            'gift-boxes.index',
            'blog.index',
            'corporate-gifts.index',
            'policies.shipping',
            'policies.refund',
            'policies.privacy',
            'policies.terms',
        ];

        foreach ($routes as $routeName) {
            $this->get(route($routeName))->assertOk();
        }
    }
}

