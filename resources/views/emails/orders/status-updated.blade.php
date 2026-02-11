<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order Status Updated</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.5;">
    <p>Hello {{ $order->user->name }},</p>

    <p>Your order <strong>#{{ $order->id }}</strong> has a new status.</p>

    <p>
        <strong>Previous status:</strong> {{ ucfirst($previousStatus) }}<br>
        <strong>Current status:</strong> {{ ucfirst($currentStatus) }}
    </p>

    <p>
        <strong>Order total:</strong> INR {{ number_format($order->total, 2) }}
    </p>

    <p>
        View your order details:
        <a href="{{ route('orders.show', $order) }}">{{ route('orders.show', $order) }}</a>
    </p>

    <p>Thank you,<br>Spice Basket</p>
</body>
</html>
