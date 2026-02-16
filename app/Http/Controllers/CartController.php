<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\CartSynchronizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $syncResult = $this->syncCart($request);
        $cart = $syncResult['cart'];
        $totals = $this->calculateTotals($cart);

        return view('shop.cart', [
            'cart' => $cart,
            'totals' => $totals,
            'notices' => $this->syncNotices($syncResult),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        if (!$product->is_active) {
            return redirect()->route('products.index')->with('status', 'This product is not available.');
        }

        if ((int) $product->stock_qty <= 0) {
            return redirect()->route('cart.index')->with('status', 'This product is currently out of stock.');
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

        $requestedQuantity = (int) ($validated['quantity'] ?? 1);
        $selectedWeight = trim((string) ($validated['selected_weight'] ?? $product->unit));
        if ($selectedWeight === '') {
            $selectedWeight = 'unit';
        }
        $selectedPrice = $product->priceForWeight($selectedWeight);
        $lineKey = $this->lineKey($product->id, $selectedWeight);
        $syncResult = $this->syncCart($request);
        $cart = $syncResult['cart'];

        $availableToAdd = max((int) $product->stock_qty - $this->totalProductQuantityInCart($cart, $product->id), 0);
        if ($availableToAdd <= 0) {
            return redirect()->route('cart.index')->with('status', 'No more stock is available for this product.');
        }

        $quantity = min($requestedQuantity, $availableToAdd);

        if (isset($cart[$lineKey])) {
            $cart[$lineKey]['quantity'] += $quantity;
            $cart[$lineKey]['price'] = $selectedPrice;
            $cart[$lineKey]['stock_qty'] = (int) $product->stock_qty;
        } else {
            $cart[$lineKey] = [
                'key' => $lineKey,
                'id' => $product->id,
                'name' => $product->name,
                'price' => $selectedPrice,
                'unit' => $selectedWeight,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
                'stock_qty' => (int) $product->stock_qty,
            ];
        }

        $this->storeCart($request, $cart);

        $status = $quantity < $requestedQuantity
            ? 'Only '.$quantity.' unit(s) were added due to limited stock.'
            : 'Item added to cart.';

        return redirect()->route('cart.index')->with('status', $status);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->syncCart($request)['cart'];

        foreach ($data['items'] as $lineKey => $quantity) {
            if (isset($cart[$lineKey])) {
                $cart[$lineKey]['quantity'] = (int) $quantity;
            }
        }

        $this->storeCart($request, $cart);
        $syncResult = $this->syncCart($request);

        $status = 'Cart updated.';
        if ($syncResult['item_removed'] && $syncResult['stock_adjusted']) {
            $status = 'Cart updated. Some items were removed because stock is unavailable.';
        } elseif ($syncResult['stock_adjusted']) {
            $status = 'Cart updated. Quantities were adjusted to match available stock.';
        } elseif ($syncResult['item_removed']) {
            $status = 'Cart updated. Some unavailable items were removed.';
        }

        return redirect()->route('cart.index')->with('status', $status);
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->syncCart($request)['cart'];

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
     * @return array{
     *     cart: array<string, array<string, mixed>>,
     *     changed: bool,
     *     price_changed: bool,
     *     item_removed: bool,
     *     unit_adjusted: bool,
     *     stock_adjusted: bool
     * }
     */
    private function syncCart(Request $request): array
    {
        $result = app(CartSynchronizer::class)->sync($request->session()->get('cart', []));

        if ($result['changed']) {
            $this->storeCart($request, $result['cart']);
        }

        return $result;
    }

    /**
     * @param array{
     *     price_changed: bool,
     *     item_removed: bool,
     *     unit_adjusted: bool,
     *     stock_adjusted: bool
     * } $syncResult
     * @return list<string>
     */
    private function syncNotices(array $syncResult): array
    {
        $notices = [];

        if ($syncResult['price_changed']) {
            $notices[] = 'Some spice rates were refreshed to current prices.';
        }

        if ($syncResult['unit_adjusted']) {
            $notices[] = 'Some cart units were adjusted based on current product options.';
        }

        if ($syncResult['stock_adjusted']) {
            $notices[] = 'Some cart quantities were adjusted to available stock.';
        }

        if ($syncResult['item_removed']) {
            $notices[] = 'Unavailable items were removed from your cart.';
        }

        return $notices;
    }

    private function totalProductQuantityInCart(array $cart, int $productId): int
    {
        $total = 0;

        foreach ($cart as $item) {
            if ((int) ($item['id'] ?? 0) !== $productId) {
                continue;
            }

            $total += max((int) ($item['quantity'] ?? 0), 0);
        }

        return $total;
    }
}
