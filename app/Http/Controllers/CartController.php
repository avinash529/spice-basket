<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        $totals = $this->calculateTotals($cart);

        return view('shop.cart', [
            'cart' => $cart,
            'totals' => $totals,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        if (!$product->is_active) {
            return redirect()->route('products.index')->with('status', 'This product is not available.');
        }

        $weightOptions = $product->weightOptions();
        $rules = [
            'quantity' => ['nullable', 'integer', 'min:1'],
            'selected_weight' => ['nullable', 'string', 'max:50'],
        ];

        if (!empty($weightOptions)) {
            $rules['selected_weight'] = ['required', 'string', Rule::in($weightOptions)];
        }

        $validated = $request->validate($rules);

        $quantity = (int) ($validated['quantity'] ?? 1);
        $selectedWeight = (string) ($validated['selected_weight'] ?? $product->unit);
        $selectedPrice = $product->priceForWeight($selectedWeight);
        $lineKey = $this->lineKey($product->id, $selectedWeight);
        $cart = $this->getCart($request);

        if (isset($cart[$lineKey])) {
            $cart[$lineKey]['quantity'] += $quantity;
            $cart[$lineKey]['price'] = $selectedPrice;
        } else {
            $cart[$lineKey] = [
                'key' => $lineKey,
                'id' => $product->id,
                'name' => $product->name,
                'price' => $selectedPrice,
                'unit' => $selectedWeight,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
            ];
        }

        $this->storeCart($request, $cart);

        return redirect()->route('cart.index')->with('status', 'Item added to cart.');
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCart($request);

        foreach ($data['items'] as $lineKey => $quantity) {
            if (isset($cart[$lineKey])) {
                $cart[$lineKey]['quantity'] = (int) $quantity;
            }
        }

        $this->storeCart($request, $cart);

        return redirect()->route('cart.index')->with('status', 'Cart updated.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->getCart($request);

        $lineKey = (string) $request->input('line_key', '');
        if ($lineKey !== '' && isset($cart[$lineKey]) && (int) $cart[$lineKey]['id'] === $product->id) {
            unset($cart[$lineKey]);
        } else {
            foreach ($cart as $key => $item) {
                if ((int) ($item['id'] ?? 0) === $product->id) {
                    unset($cart[$key]);
                }
            }
        }

        $this->storeCart($request, $cart);

        return redirect()->route('cart.index')->with('status', 'Item removed.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $this->storeCart($request, []);

        return redirect()->route('cart.index')->with('status', 'Cart cleared.');
    }

    private function getCart(Request $request): array
    {
        return $this->normalizeCart($request->session()->get('cart', []));
    }

    private function storeCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    private function calculateTotals(array $cart): array
    {
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return [
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ];
    }

    private function lineKey(int $productId, string $weight): string
    {
        return $productId.'::'.strtolower(trim($weight));
    }

    /**
     * @param array<mixed> $cart
     * @return array<string, array<string, mixed>>
     */
    private function normalizeCart(array $cart): array
    {
        $normalized = [];

        foreach ($cart as $key => $item) {
            if (!is_array($item) || !isset($item['id'])) {
                continue;
            }

            $productId = (int) $item['id'];
            if ($productId <= 0) {
                continue;
            }

            $unit = trim((string) ($item['unit'] ?? $item['selected_unit'] ?? ''));
            if ($unit === '') {
                $unit = 'unit';
            }

            $lineKey = is_string($key) && $key !== '' ? $key : $this->lineKey($productId, $unit);
            $quantity = max((int) ($item['quantity'] ?? 1), 1);

            if (isset($normalized[$lineKey])) {
                $normalized[$lineKey]['quantity'] += $quantity;
                continue;
            }

            $normalized[$lineKey] = [
                'key' => $lineKey,
                'id' => $productId,
                'name' => (string) ($item['name'] ?? 'Product'),
                'price' => (float) ($item['price'] ?? 0),
                'unit' => $unit,
                'image_url' => $item['image_url'] ?? null,
                'quantity' => $quantity,
            ];
        }

        return $normalized;
    }
}
