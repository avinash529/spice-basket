<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order Placed</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.5;">
    <p>Hello {{ $order->user->name }},</p>

    <p>Thank you for your order. Your order <strong>#{{ $order->id }}</strong> has been placed successfully.</p>

    <p><strong>Order summary</strong></p>
    <table cellpadding="6" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 560px;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #d1d5db;">
                <th>Item</th>
                <th>Qty</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td>{{ $item->product->name ?? 'Product' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>INR {{ number_format($item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 12px;">
        <strong>Total:</strong> INR {{ number_format($order->total, 2) }}
    </p>

    @if($order->shipping_full_name)
        <p style="margin-top: 16px;"><strong>Shipping address</strong></p>
        <p style="margin: 0;">
            {{ $order->shipping_full_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_house_street }}<br>
            {{ $order->shipping_district }} - {{ $order->shipping_pincode }}
        </p>
    @endif

    <p style="margin-top: 16px;">
        You can view your order here:
        <a href="{{ route('orders.show', $order) }}">{{ route('orders.show', $order) }}</a>
    </p>

    <p>Thank you,<br>Spice Basket</p>
</body>
</html>
