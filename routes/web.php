<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product:id}', [ShopController::class, 'show'])->name('product.show');

// Cart
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

// Wishlist — page requires auth, toggle works for both guests (returns 401 JSON -> redirect to login) and auth users
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');

use App\Http\Controllers\Customer\AccountProfileController;

// Checkout + Customer Account Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // My Account
    Route::get('/account/profile', [AccountProfileController::class, 'edit'])->name('account.profile');
    Route::put('/account/profile', [AccountProfileController::class, 'update'])->name('account.profile.update');
});

// Admin Routes
Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Products
    Route::prefix('admin/products')->name('admin.products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });
    
    // Categories
    Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    
    // Users
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
    
    // Orders
    Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
    });
});

// Reviews (customer ratings/reviews)
Route::middleware(['auth'])->group(function () {
    Route::post('/product/{product}/reviews', [App\Http\Controllers\Customer\ReviewController::class, 'store'])
        ->name('product.reviews.store');
});

// Customer account - Orders + Tracking
Route::middleware('auth')->group(function () {
    Route::get('/account/orders', [\App\Http\Controllers\Customer\AccountOrderController::class, 'index'])
        ->name('account.orders.index');

    Route::get('/account/orders/{order}', [\App\Http\Controllers\Customer\AccountOrderController::class, 'show'])
        ->name('account.orders.show');

    Route::get('/account/tracking', [\App\Http\Controllers\Customer\AccountOrderController::class, 'tracking'])
        ->name('account.tracking');
});

// Support Pages
Route::prefix('support')->name('support.')->group(function () {
    Route::get('/faq', function () {
        return view('customer.support.faq');
    })->name('faq');

    Route::get('/shipping', function () {
        return view('customer.support.shipping');
    })->name('shipping');

    Route::get('/returns', function () {
        return view('customer.support.returns');
    })->name('returns');

    Route::get('/contact', function () {
        return view('customer.support.contact');
    })->name('contact');
});

// Legal Pages
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/return-policy', function () {
        return view('customer.legal.return-policy');
    })->name('return-policy');

    Route::get('/terms', function () {
        return view('customer.legal.terms');
    })->name('terms');

    Route::get('/privacy-policy', function () {
        return view('customer.legal.privacy-policy');
    })->name('privacy-policy');
});

// Auth routes - Laravel Breeze or manual implementation
require __DIR__.'/auth.php';

