<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\InventoryMovement;
use App\Models\OrderItem;
use App\Models\Product;
use App\Rules\KeralaPhone;
use App\Rules\KeralaPincode;
use App\Support\Kerala;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('status', 'Your cart is empty.');
        }

        $totals = $this->calculateTotals($cart);
        $addresses = $request->user()
            ->addresses()
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return view('shop.checkout', [
            'cart' => $cart,
            'totals' => $totals,
            'addresses' => $addresses,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('status', 'Your cart is empty.');
        }

        $totals = $this->calculateTotals($cart);
        $user = $request->user();
        $hasAddresses = $user->addresses()->exists();

        if ($hasAddresses) {
            $addressData = $request->validate([
                'address_id' => [
                    'required',
                    'integer',
                    Rule::exists('addresses', 'id')->where(
                        fn ($query) => $query->where('user_id', $user->id)
                    ),
                ],
            ]);

            $address = $user->addresses()->findOrFail($addressData['address_id']);
        } else {
            $addressPayload = $request->validate([
                'full_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20', new KeralaPhone],
                'house_street' => ['required', 'string', 'max:500'],
                'district' => ['required', 'string', Rule::in(Kerala::DISTRICTS)],
                'pincode' => ['required', 'string', 'size:6', new KeralaPincode],
            ]);

            $addressPayload['pincode'] = Kerala::digitsOnly((string) $addressPayload['pincode']);
            $addressPayload['is_default'] = true;

            $address = $user->addresses()->create($addressPayload);
        }

        $productQuantities = [];
        foreach ($cart as $item) {
            $productQuantities[(int) $item['id']] = ($productQuantities[(int) $item['id']] ?? 0) + (int) $item['quantity'];
        }

        foreach ($productQuantities as $productId => $requestedQuantity) {
            $product = Product::find($productId);
            if (!$product || !$product->is_active) {
                return redirect()->route('cart.index')->with('status', 'One or more items are unavailable.');
            }
            if ($product->stock_qty < $requestedQuantity) {
                return redirect()->route('cart.index')->with('status', 'Insufficient stock for ' . $product->name . '.');
            }
        }

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'status' => 'placed',
            'subtotal' => $totals['subtotal'],
            'total' => $totals['total'],
            'shipping_full_name' => $address->full_name,
            'shipping_phone' => $address->phone,
            'shipping_house_street' => $address->house_street,
            'shipping_district' => $address->district,
            'shipping_pincode' => $address->pincode,
        ]);

        $order->statusHistory()->create([
            'status' => 'placed',
            'changed_by' => $user->id,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'line_total' => $item['price'] * $item['quantity'],
            ]);

            Product::whereKey($item['id'])->decrement('stock_qty', $item['quantity']);
            InventoryMovement::create([
                'product_id' => $item['id'],
                'type' => 'out',
                'quantity' => $item['quantity'],
                'source_type' => 'order',
                'source_id' => $order->id,
                'note' => 'Order #' . $order->id,
            ]);
        }

        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('status', 'Order placed successfully.');
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
}
