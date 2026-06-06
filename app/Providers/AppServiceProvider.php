<?php

namespace App\Providers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share data with the customer-facing app layout (cart + wishlist).
        View::composer('layouts.app', function ($view) {
            $cart = app(CartService::class);
            $wishlist = app(WishlistService::class);

            $view->with([
                'featuredProducts' => Product::where('is_featured', true)
                    ->where('is_active', true)
                    ->take(4)
                    ->get(),
                'cartItems' => $cart->items(),
                'cartCount' => $cart->count(),
                'cartSubtotal' => $cart->subtotal(),
                'wishlistCount' => $wishlist->count(),
                'wishlistProductIds' => $wishlist->productIds(),
            ]);
        });
    }
}
