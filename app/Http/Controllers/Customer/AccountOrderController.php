<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.account.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product']);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.account.orders.show', compact('order'));
    }

    public function tracking(): View
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->where('order_status', '!=', 'delivered')
            ->latest()
            ->get();

        return view('customer.account.tracking', compact('orders'));
    }
}
