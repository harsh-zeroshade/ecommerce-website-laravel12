<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart)
    {
        // auth middleware is applied on routes/web.php
    }

    public function index(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('shop.index')->with('success', 'Your cart is empty.');
        }

        return view('customer.checkout', [
            'cartItems' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'shipping' => $this->cart->subtotal() >= 999 ? 0 : 99,
            'tax' => round($this->cart->subtotal() * 0.05, 2),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('shop.index');
        }

        $validated = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zipcode' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:20'],
            // Payment method is COD-only for now (we still accept the field but it is not trusted)
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $subtotal = $this->cart->subtotal();
        $shipping = $subtotal >= 999 ? 0 : 99;
        $tax = round($subtotal * 0.05, 2);
        $total = $subtotal + $shipping + $tax;

        try {
        $order = DB::transaction(function () use ($validated, $subtotal, $shipping, $tax, $total) {
            foreach ($this->cart->items() as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);
                if (!$product || $product->stock < $item['quantity']) {
                    throw new \RuntimeException("Insufficient stock for {$item['name']}.");
                }
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ADG' . strtoupper(uniqid()),
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'discount_amount' => 0,
                'total_amount' => $total,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_address' => [
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'zipcode' => $validated['zipcode'],
                    'phone' => $validated['phone'],
                ],
                'notes' => $validated['notes'],
            ]);

            foreach ($this->cart->items() as $item) {
                $product = Product::find($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['line_total'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            $this->cart->clear();

            return $order;
        });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['stock' => $e->getMessage()])->withInput();
        }

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    public function success(Order $order): View|RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.order-success', compact('order'));
    }
}
