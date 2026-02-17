<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Farmer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@spicebasket.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone' => '9876501234',
                'role' => 'admin',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@spicebasket.test'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'phone' => '9876505678',
                'role' => 'user',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'wholesale@spicebasket.test'],
            [
                'name' => 'Demo Wholesale',
                'password' => Hash::make('password'),
                'phone' => '9876509012',
                'role' => 'wholesale',
            ]
        );

        $categories = collect([
            'Whole Spices',
            'Ground Spices',
            'Signature Blends',
            'Seeds',
        ])->map(function ($name) {
            return Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true]
            );
        });

        $farmers = collect([
            ['name' => 'Lakshmi Farms', 'location' => 'Kerala'],
            ['name' => 'Golden Harvest', 'location' => 'Tamil Nadu'],
            ['name' => 'Hilltop Co-op', 'location' => 'Karnataka'],
        ])->map(function ($farmer) {
            return Farmer::query()->updateOrCreate(
                ['name' => $farmer['name']],
                ['location' => $farmer['location'], 'is_active' => true]
            );
        });

        $products = [
            ['Turmeric Powder', 'Ground Spices', 120.00, '100g', 'Erode', true],
            ['Black Pepper Whole', 'Whole Spices', 180.00, '100g', 'Wayanad', true],
            ['Cardamom Pods', 'Whole Spices', 320.00, '50g', 'Idukki', true],
            ['Coriander Seeds', 'Seeds', 90.00, '200g', 'Coimbatore', false],
            ['Garam Masala Blend', 'Signature Blends', 150.00, '100g', 'Spice Basket', true],
        ];

        foreach ($products as [$name, $categoryName, $price, $unit, $origin, $featured]) {
            $category = $categories->firstWhere('name', $categoryName);
            $farmer = $farmers->random();

            Product::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => 'Freshly sourced and packed for peak flavor.',
                    'price' => $price,
                    'unit' => $unit,
                    'stock_qty' => 50,
                    'origin' => $origin,
                    'category_id' => $category?->id,
                    'farmer_id' => $farmer->id,
                    'is_active' => true,
                    'is_featured' => $featured,
                ]
            );
        }
    }
}
