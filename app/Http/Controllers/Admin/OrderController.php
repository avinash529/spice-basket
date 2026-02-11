<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $previousStatus = $order->status;

        if ($previousStatus !== $data['status']) {
            $order->statusHistory()->create([
                'status' => $data['status'],
                'changed_by' => $request->user()->id,
            ]);
        }

        $order->update($data);

        if ($previousStatus !== $data['status']) {
            $order->loadMissing('user');
            Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order, $previousStatus, $data['status']));
        }

        return redirect()->route('admin.orders.show', $order)->with('status', 'Order updated.');
    }
}
