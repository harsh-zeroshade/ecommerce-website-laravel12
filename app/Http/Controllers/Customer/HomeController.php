<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        $newArrivals = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->take(6)
            ->get();

        $topRatedProducts = Product::where('is_active', true)
            ->orderBy('rating', 'desc')
            ->take(8)
            ->get();

        return view('customer.home', compact(
            'featuredProducts',
            'newArrivals',
            'categories',
            'topRatedProducts'
        ));
    }
}
