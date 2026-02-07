<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'statusHistory');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
        ]);

        if ($order->status !== $data['status']) {
            $order->statusHistory()->create([
                'status' => $data['status'],
                'changed_by' => $request->user()->id,
            ]);
        }

        $order->update($data);

        return redirect()->route('admin.orders.show', $order)->with('status', 'Order updated.');
    }
}
