<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $today = $now->toDateString();
        $monthStart = $now->copy()->startOfMonth();
        $trendStart = $now->copy()->subDays(6)->startOfDay();
        $lowStockThreshold = 10;

        $totalOrders = Order::count();
        $totalRevenue = (float) Order::sum('total');

        $stats = [
            'products_total' => Product::count(),
            'products_active' => Product::where('is_active', true)->count(),
            'categories_total' => Category::count(),
            'orders_total' => $totalOrders,
            'orders_pending' => Order::whereIn('status', [
                Order::STATUS_PENDING,
                Order::STATUS_PLACED,
                Order::STATUS_PROCESSING,
            ])->count(),
            'customers_total' => User::where('role', 'user')->count(),
            'revenue_total' => $totalRevenue,
            'revenue_today' => (float) Order::whereDate('created_at', $today)->sum('total'),
            'revenue_month' => (float) Order::where('created_at', '>=', $monthStart)->sum('total'),
            'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0.0,
            'low_stock_count' => Product::where('is_active', true)
                ->whereBetween('stock_qty', [1, $lowStockThreshold])
                ->count(),
            'out_of_stock_count' => Product::where('is_active', true)
                ->where('stock_qty', 0)
                ->count(),
        ];

        $statusBreakdown = Order::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $topProducts = OrderItem::query()
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(line_total) as total_revenue'))
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        $stockAlerts = Product::query()
            ->where('is_active', true)
            ->where('stock_qty', '<=', $lowStockThreshold)
            ->orderBy('stock_qty')
            ->take(8)
            ->get(['id', 'name', 'stock_qty', 'unit']);

        $salesRows = Order::query()
            ->selectRaw('DATE(created_at) as order_date, COUNT(*) as orders_count, SUM(total) as revenue_total')
            ->where('created_at', '>=', $trendStart)
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get()
            ->keyBy('order_date');

        $salesTrend = collect(range(6, 0))->map(function (int $offset) use ($now, $salesRows) {
            $date = $now->copy()->subDays($offset);
            $key = $date->toDateString();
            $row = $salesRows->get($key);

            return [
                'date' => $key,
                'label' => $date->format('D'),
                'orders' => (int) ($row->orders_count ?? 0),
                'revenue' => (float) ($row->revenue_total ?? 0),
            ];
        });

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'statusBreakdown',
            'topProducts',
            'stockAlerts',
            'salesTrend',
            'recentOrders',
            'lowStockThreshold',
        ));
    }
}
