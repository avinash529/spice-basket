<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featured = Product::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();

        $offerProducts = Product::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderByDesc('updated_at')
            ->take(4)
            ->get();

        $giftBoxProducts = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->where(function ($builder) {
                $builder
                    ->where('name', 'like', '%gift%')
                    ->orWhere('name', 'like', '%box%')
                    ->orWhere('description', 'like', '%gift%')
                    ->orWhereHas('category', function ($categoryQuery) {
                        $categoryQuery
                            ->where('name', 'like', '%gift%')
                            ->orWhere('name', 'like', '%box%');
                    });
            })
            ->take(4)
            ->get();

        if ($giftBoxProducts->isEmpty()) {
            $giftBoxProducts = Product::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->with('category')
                ->take(4)
                ->get();
        }

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('shop.home', compact('featured', 'offerProducts', 'giftBoxProducts', 'categories'));
    }

    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($builder) use ($request) {
                $builder->where('slug', $request->string('category'));
            });
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->with(['category', 'farmer'])->paginate(12)->withQueryString();
        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();

        return view('shop.products', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $related = Product::query()
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.product', compact('product', 'related'));
    }
}
