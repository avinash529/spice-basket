<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CorporateInquiry;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function spicesGuide(): View
    {
        $spices = [
            ['name' => 'Black Pepper', 'notes' => 'Warm and sharp', 'uses' => 'Curries, soups, marinades'],
            ['name' => 'Cardamom', 'notes' => 'Sweet and floral', 'uses' => 'Tea, desserts, biryani'],
            ['name' => 'Cloves', 'notes' => 'Intense and woody', 'uses' => 'Masala chai, pulao, pickles'],
            ['name' => 'Cinnamon', 'notes' => 'Sweet and earthy', 'uses' => 'Bakes, stews, spice blends'],
            ['name' => 'Turmeric', 'notes' => 'Earthy and bitter', 'uses' => 'Curries, rice, marinades'],
            ['name' => 'Cumin', 'notes' => 'Nutty and smoky', 'uses' => 'Tempering, lentils, masala mixes'],
            ['name' => 'Fennel', 'notes' => 'Mildly sweet', 'uses' => 'Seafood, breads, digestion teas'],
            ['name' => 'Nutmeg', 'notes' => 'Warm and sweet', 'uses' => 'Desserts, sauces, festive dishes'],
        ];

        $faqs = [
            [
                'question' => 'Why is Kerala called the land of spices?',
                'answer' => 'Kerala has ideal climate and long trade history for pepper, cardamom, cinnamon, and cloves.',
            ],
            [
                'question' => 'How should I store spices?',
                'answer' => 'Keep spices in airtight containers away from heat, moisture, and direct sunlight.',
            ],
            [
                'question' => 'Whole spices or powdered spices?',
                'answer' => 'Whole spices hold aroma longer. Powdered spices are faster to use for daily cooking.',
            ],
            [
                'question' => 'How long do spices stay fresh?',
                'answer' => 'Whole spices are best within 18-24 months, powders within 6-12 months for peak aroma.',
            ],
        ];

        return view('pages.spices-guide', compact('spices', 'faqs'));
    }

    public function offers(Request $request): View
    {
        $query = Product::query()
            ->where('is_active', true)
            ->withActiveOffers()
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('updated_at');

        if ($request->filled('category')) {
            $query->whereHas('category', function (Builder $builder) use ($request) {
                $builder->where('slug', (string) $request->string('category'));
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();

        return view('pages.offers', compact('products', 'categories'));
    }

    public function giftBoxes(): View
    {
        $query = $this->giftBoxQuery();
        if (! $query->exists()) {
            $query = Product::query()->where('is_active', true)->where('is_featured', true);
        }

        $products = $query->with('category')->orderByDesc('updated_at')->paginate(12);

        return view('pages.gift-boxes', compact('products'));
    }

    public function blog(): View
    {
        $posts = [
            [
                'title' => 'How to Identify High-Quality Black Pepper',
                'slug' => 'identify-high-quality-black-pepper',
                'excerpt' => 'Simple checks for size, aroma, and freshness before you buy.',
                'read_time' => '4 min read',
                'tag' => 'Buying Guide',
                'published_at' => 'January 18, 2026',
            ],
            [
                'title' => 'Kerala Spice Pairings for Everyday Cooking',
                'slug' => 'kerala-spice-pairings-everyday-cooking',
                'excerpt' => 'Build better flavors with practical spice pairings for home kitchens.',
                'read_time' => '5 min read',
                'tag' => 'Cooking Tips',
                'published_at' => 'December 29, 2025',
            ],
            [
                'title' => 'Whole Spices vs Ground Spices: When to Use What',
                'slug' => 'whole-vs-ground-spices',
                'excerpt' => 'When to toast, grind, or sprinkle for stronger aroma and balance.',
                'read_time' => '6 min read',
                'tag' => 'Kitchen Basics',
                'published_at' => 'November 21, 2025',
            ],
            [
                'title' => 'Storage Mistakes That Kill Spice Aroma',
                'slug' => 'storage-mistakes-that-kill-spice-aroma',
                'excerpt' => 'Prevent moisture, heat, and sunlight from flattening your spice profile.',
                'read_time' => '3 min read',
                'tag' => 'Care & Storage',
                'published_at' => 'October 07, 2025',
            ],
            [
                'title' => 'Kerala Cardamom Grades Explained',
                'slug' => 'kerala-cardamom-grades-explained',
                'excerpt' => 'Understand grade, color, and size so you can buy with confidence.',
                'read_time' => '5 min read',
                'tag' => 'Buyer Education',
                'published_at' => 'September 14, 2025',
            ],
            [
                'title' => 'Building a Starter Spice Shelf for Indian Cooking',
                'slug' => 'starter-spice-shelf-for-indian-cooking',
                'excerpt' => 'A practical starter list to build balanced flavor in daily meals.',
                'read_time' => '4 min read',
                'tag' => 'Starter Guide',
                'published_at' => 'August 25, 2025',
            ],
        ];

        return view('pages.blog', compact('posts'));
    }

    public function corporateGiftBoxes(): View
    {
        $giftProducts = $this->giftBoxQuery()
            ->with('category')
            ->orderByDesc('updated_at')
            ->take(6)
            ->get();

        if ($giftProducts->isEmpty()) {
            $giftProducts = Product::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->with('category')
                ->orderByDesc('updated_at')
                ->take(6)
                ->get();
        }

        return view('pages.corporate-gift-boxes', compact('giftProducts'));
    }

    public function storeCorporateInquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'company' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
        ]);

        CorporateInquiry::query()->create($validated);

        return redirect()
            ->route('corporate-gifts.index')
            ->with('status', 'Thanks. We received your inquiry and will contact you shortly.');
    }

    public function shippingPolicy(): View
    {
        return view('pages.policies.shipping');
    }

    public function refundPolicy(): View
    {
        return view('pages.policies.refund');
    }

    public function privacyPolicy(): View
    {
        return view('pages.policies.privacy');
    }

    public function terms(): View
    {
        return view('pages.policies.terms');
    }

    private function giftBoxQuery(): Builder
    {
        return Product::query()
            ->where('is_active', true)
            ->where(function (Builder $builder) {
                $builder
                    ->where('name', 'like', '%gift%')
                    ->orWhere('name', 'like', '%box%')
                    ->orWhere('description', 'like', '%gift%')
                    ->orWhereHas('category', function (Builder $categoryQuery) {
                        $categoryQuery
                            ->where('name', 'like', '%gift%')
                            ->orWhere('name', 'like', '%box%');
                    });
            });
    }
}
