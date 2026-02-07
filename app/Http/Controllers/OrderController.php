<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    public function show(Order $order, Request $request)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $order->load('items.product', 'statusHistory');

        return view('shop.orders.show', compact('order'));
    }
}
