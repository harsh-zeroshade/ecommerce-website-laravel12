<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'completed')
            ->sum('total_amount');

        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::withCount('reviews')
            ->withAvg('reviews as rating_avg', 'rating')
            ->orderBy('reviews_count', 'desc')
            ->take(5)
            ->get()
            ->each(function ($product) {
                // Make `$product->rating` reflect the live average of reviews
                // (the `rating` column is only refreshed by ReviewController::store),
                // so the dashboard always shows up-to-date stars.
                $product->rating = (float) ($product->rating_avg ?? 0);
            });

        $orderStatusStats = Order::select('order_status', DB::raw('count(*) as count'))
            ->groupBy('order_status')
            ->get()
            ->pluck('count', 'order_status');

        $monthlyRevenue = Order::where('payment_status', 'completed')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'topProducts',
            'orderStatusStats',
            'monthlyRevenue'
        ));
    }
}

