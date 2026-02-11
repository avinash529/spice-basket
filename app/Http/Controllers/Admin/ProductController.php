<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Farmer;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'farmer'])->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $farmers = Farmer::orderBy('name')->get();
        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')->with('status', 'Create a category before adding products.');
        }

        $requestedCategoryId = (int) $request->input('category_id');
        $selectedCategoryId = $categories->contains('id', $requestedCategoryId)
            ? $requestedCategoryId
            : (int) $categories->first()->id;

        return view('admin.products.create', compact('categories', 'farmers', 'selectedCategoryId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProduct($request);
        $data['weight'] = $this->normalizeWeightOptions($request);
        unset($data['weight_options']);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $this->handleImageUpload($request, $data);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $farmers = Farmer::orderBy('name')->get();
        $purchases = $product->purchases()->with('farmer')->latest()->take(10)->get();
        $movements = $product->movements()->latest()->take(10)->get();

        return view('admin.products.edit', compact('product', 'categories', 'farmers', 'purchases', 'movements'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validateProduct($request);
        $data['weight'] = $this->normalizeWeightOptions($request);
        unset($data['weight_options']);
        $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $this->handleImageUpload($request, $data, $product);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    public function addStock(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'farmer_id' => ['required', 'exists:farmers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['nullable', 'string', 'max:20'],
            'price_per_unit' => ['nullable', 'numeric', 'min:0'],
            'purchased_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $purchase = $product->purchases()->create([
            'farmer_id' => $data['farmer_id'],
            'user_id' => $request->user()->id,
            'quantity' => $data['quantity'],
            'unit' => $data['unit'] ?: $product->unit,
            'price_per_unit' => $data['price_per_unit'] ?? null,
            'purchased_at' => $data['purchased_at'] ?? now(),
            'notes' => $data['notes'] ?? null,
        ]);

        $product->increment('stock_qty', $data['quantity']);
        InventoryMovement::create([
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $data['quantity'],
            'source_type' => 'purchase',
            'source_id' => $purchase->id,
            'note' => 'Purchased from farmer',
        ]);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Stock updated.');
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'weight_options' => ['nullable', 'array'],
            'weight_options.*.label' => ['nullable', 'string', 'max:50'],
            'weight_options.*.price' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
            'stock_qty' => ['required', 'integer', 'min:0'],
            'origin' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
            'farmer_id' => ['nullable', 'exists:farmers,id'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);
    }

    private function normalizeWeightOptions(Request $request): ?string
    {
        $options = $request->input('weight_options', []);
        if (! is_array($options)) {
            return null;
        }

        $normalized = [];

        foreach ($options as $option) {
            if (! is_array($option)) {
                continue;
            }

            $label = trim((string) ($option['label'] ?? ''));
            if ($label === '') {
                continue;
            }

            $priceInput = $option['price'] ?? null;
            $price = null;

            if ($priceInput !== null && $priceInput !== '') {
                $price = round((float) $priceInput, 2);
            }

            $normalized[$label] = $price;
        }

        if ($normalized === []) {
            return null;
        }

        return json_encode($normalized, JSON_UNESCAPED_UNICODE);
    }

    private function handleImageUpload(Request $request, array &$data, ?Product $product = null): void
    {
        if (!$request->hasFile('image_file')) {
            return;
        }

        $path = $request->file('image_file')->store('products', 'public');
        $data['image_url'] = $path;

        if (!$product || !$product->image_url) {
            return;
        }

        $old = $product->image_url;
        if (Str::startsWith($old, ['http://', 'https://', 'images/'])) {
            return;
        }

        $old = Str::startsWith($old, 'storage/') ? Str::after($old, 'storage/') : $old;
        Storage::disk('public')->delete($old);
    }

    private function uniqueSlug(string $name, ?int $ignoreProductId = null): string
    {
        $baseSlug = Str::slug($name);
        if ($baseSlug === '') {
            $baseSlug = 'product';
        }

        $candidate = $baseSlug;
        $suffix = 2;

        while (
            Product::query()
                ->when($ignoreProductId, fn ($query) => $query->whereKeyNot($ignoreProductId))
                ->where('slug', $candidate)
                ->exists()
        ) {
            $candidate = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $candidate;
    }
}
